<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class KolkoImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $siteID     = 229; // kolko group id
        $site       = Site::find($siteID);
        $file       = public_path('tmp/kolko.xlf');
        try {
            $countBlocks = 0;
            $xml = simplexml_load_file($file);
            $globalProps = [];
            foreach($xml->file->attributes() as $name => $value) {
                $globalProps[$name] = strval($value);
            }
            if (empty($globalProps['source-language'])) {
                return redirect()->back()->withErrors('Не указан язык-источник');
            }
            if (empty($globalProps['target-language'])) {
                return redirect()->back()->withErrors('Не указан язык перевода');
            }
            $sourceLang = Language::where('export', $globalProps['source-language'])
                ->orWhere('short', $globalProps['source-language'])->first();
            if (!$sourceLang) {
                return redirect()->back()->withErrors('Язык-источник не найден в базе');
            }
            $targetLang = Language::where('export', $globalProps['target-language'])
                ->orWhere('short', $globalProps['target-language'])->first();
            if (!$targetLang) {
                return redirect()->back()->withErrors('Язык перевода не найден в базе');
            }
            if (!$site->hasLanguage($targetLang->id)) {
                return redirect()->back()->withErrors('Язык перевода не связан с сайтом. Добавьте выбранный язык к сайту в личном кабинете');
            }
            foreach($xml->file->body->children() as $unit) {
                $blockId = intval($unit->attributes()['id']);
                if (!empty($unit->target)) {
                    $translate = Translate::where('block_id', $blockId)->where('language_id', $targetLang->id)->first();
                    if ($translate) {
                        if (!empty($translate->text) && $translate->text != strval($unit->target)) {
                            HistoryPhrase::create([
                                'translate_id' => $translate->id,
                                'text'         => $translate->text,
                            ]);
                        }
                        $translate->update(['text' => strval($unit->target), 'type_translate_id' => 3]);
                        $countBlocks++;
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Неверное содержимое файла');
        }
        $targetPath = public_path('uploads/'.$siteID);
        if (!file_exists($targetPath)) {
            \File::makeDirectory($targetPath);
        }
        $fileName = str_random().'.'.$file->getClientOriginalExtension();
        $file->move($targetPath, $fileName);
        ImportHistory::create([
            'site_id' => $siteID,
            'from_language_id' => $sourceLang->id,
            'to_language_id' => $targetLang->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $fileName,
            'count_blocks' => $countBlocks,
        ]);
        echo 'finish';
    }
}
