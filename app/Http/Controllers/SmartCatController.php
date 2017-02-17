<?php

namespace App\Http\Controllers;

use App\Site;
use App\Block;
use App\Page;
use App\UserDetail;
use App\Language;
use Illuminate\Http\Request;

use App\Http\Requests;
use SmartCAT\API\Model\CreateProjectWithFilesModel;
use SmartCAT\API\SmartCAT;

class SmartCatController extends Controller
{
    public function XLFPrepare($id, $pageID = null, $srcLang = 'ru', $dstLang = 'en')
    {
        $lang1 = Language::where('short', $srcLang)->first();
        $lang2 = Language::where('short', $dstLang)->first();
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        if (!empty($pageID)) {
            $page = Page::find($pageID);
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"".$lang1->export."\" target-language=\"".$lang2->export."\">\n\t\t<header></header>\n\t\t\t<body>";
            foreach ($page->blocks as $block) {
                $exp .= "\n\t\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            $tmpfname = tempnam(sys_get_temp_dir(), $site->name."-".$page->url."-export.xlf"); // good
            file_put_contents($tmpfname, $exp);
        } else {
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"".$lang1->export."\" target-language=\"".$lang2->export."\">\n\t\t<header></header>\n\t\t<body>";
            foreach ($site->blocks as $block) {
                $exp .= "\n\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            $tmpfname = tempnam(sys_get_temp_dir(), $site->name."-export.xlf"); // good
            file_put_contents($tmpfname, $exp);
        }

        return $tmpfname;
    }


    public function exportSite($siteID, Request $request) {
        $site = Site::find($siteID);

        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }

        $srcLang = $site->language->short;
        if ($request->get('lang2')) {
            $dstLang = Language::where('id', $request->get('lang2'))->first()->short;
        } else {
            $dstLang = "en";
        }

        $file = $this->XLFPrepare($siteID);
        $info = pathinfo($file);
        $file_name =  basename($file,'.'.$info['extension']) . ".xlf";
        $scprj = new CreateProjectWithFilesModel();
        $scprj->setAssignToVendor(false);
        $scprj->setUseMT(false);
        $scprj->setPretranslate(false);
        $scprj->setUseTranslationMemory(false);
        $scprj->setAutoPropagateRepetitions(false);
        $scprj->setName($site->name);
        $scprj->setDescription($site->name);
        $scprj->setSourceLanguage($srcLang);
        $scprj->setTargetLanguages([$dstLang]);
        $scprj->setWorkflowStages(['translation']);
        $scprj->attacheFile($file, $file_name);

        $sc = new SmartCAT('getLoc', 'ZAttGznm');
        //$sc = new SmartCAT('getLoc', 'ZAttGznm111');

        $res = $sc->getProjectManager()->projectCreateProjectWithFiles($scprj);

        unlink($file);
        if ($res->getStatus() == 'created') {

            return redirect("https://smartcat.ai/workspace");
        } else {
            abort(404);
        }

    }
}
