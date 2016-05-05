var getloc_off,
    tmp = [];
location.search
.substr(1)
    .split("&")
    .forEach(function (item) {
    tmp = item.split("=");
    if (tmp[0] === 'getloc_off') getloc_off = decodeURIComponent(tmp[1]);
});

if ( !getloc_off )
  {
    var getloc_css        = 'body {display: none;}',
        getloc_head       = document.head || document.getElementsByTagName('head')[0],
        getloc_style      = document.createElement('style');
    getloc_style.type     = 'text/css'

    if ( getloc_style.styleSheet )
        getloc_style.styleSheet.cssText = getloc_css;
    else
        getloc_style.appendChild(document.createTextNode(getloc_css));

    getloc_head.appendChild(getloc_style)
    
    window.console.log('body -> display: none')
  }


function getloc(settings)
{
    this.auto_detected = settings['auto_detected']
    this.lang          = settings['lang']
    this.uri           = encodeURI(window.location.href).replace('#', '')
    this.secret        = settings['secret']
    this.uri_api       = 'http://api.getloc.ru/translate?'
    this.callback      = 'getloc.setTranslate'
    this.response      = ''
    this.showChoice    = true
    this.style_body    = 'block'
    this.htmlWidget    = ''
    this.originalDOM  = ''
    this.complete      = false
    this.source        = settings['source']
    this.saveLang      = settings['saveLang'] 
    this.uniqDict      = []
    this.tempUniqDict  = []
    
    /**
     * Определяем язык
     * 
     * @param    void
     * @returns  void
     */
    
    this.detect_language = function()
    {
        if ( this.auto_detected || !this.lang )
            this.lang = window.navigator.userLanguage || window.navigator.language;
    }
    
    /**
     * @param  string name
     * @returns  mixed
     */
    
    this.getCookie = function(name) 
    {
        var matches = document.cookie.match(new RegExp(
          "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));

        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    
    /**
     * @param    string name
     * @param    mixed value
     * @param    Object options
     * @returns  string
     */
    
    this.setCookie = function(name, value, options)
    {
        options = options || {};

        var expires = options.expires;

        if ( typeof expires == "number" && expires ) 
          {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
          }
          
        if ( expires && expires.toUTCString )
          {
            options.expires = expires.toUTCString();
          }

        value = encodeURIComponent(value);

        var updatedCookie = name + "=" + value;

        for ( var propName in options )
        {
            updatedCookie += "; " + propName;
            var propValue  = options[propName];
            
            if ( propValue !== true )
                updatedCookie += "=" + propValue;
        }

        document.cookie = updatedCookie;
      }
    
    /**
     * @param  string s
     * @returns string
     */
    
    this.regexpEscape = function(s)
    {
        return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }
    
    /**
     * 
     * @param {type} start
     * @param {type} output
     * @returns {undefined}\
     */
    
    this.recurseDomChildren = function(start, output)
    {
        var nodes;
        
        if ( start.childNodes )
          {
            nodes = start.childNodes;
            this.loopNodeChildren(nodes, output);
          }
    }
    
    /**
     * 
     * @param {type} nodes
     * @param {type} output
     * @returns {undefined}
     */
    
    this.loopNodeChildren = function(nodes, output)
    {
        var node;
        
        for ( var i=0; i<nodes.length; i++ )
        {
            node = nodes[i];
            if ( output )
              {                                  
                if ( node.nodeName == 'SCRIPT' || node.nodeName == 'STYLE' )
                    continue;
                
                else if ( node.nodeName == 'INPUT' || node.nodeName == 'IMG' || node.nodeName == 'META'  )
                    this.translateAttribute(node);  
                               
                else if ( node.nodeName == 'A' && node.getAttribute('title') && this.issetString(node.getAttribute('title')) )
                    node.setAttribute('title', this.issetString(node.getAttribute('title')))
                
                else
                    this.translateNode(node);
              }
            if ( node.childNodes )
              {
                this.recurseDomChildren(node, output);
              }
        }
    }
        
    /**
     * @param object node
     * @returns void
     */

    this.translateNode = function(node)
    {
        var whitespace = /^\s+$/g       

        if ( node.nodeType === 3 )
          {
            node.data = node.data.replace(whitespace, '')       
            if ( node.data )
              { 
                if ( !this.complete )  
                  {
                    if ( !this.response.results[this.decodeSpecialChars(node.data)] )
                      {
                        isTrim = this.response.results[this.decodeSpecialChars(node.data.replace(/  +/g, ' ').trim())]
                        if ( isTrim )
                          {
                            this.uniqDict[isTrim]   = node.data
                            node.data               = isTrim
                          }
                      }
                    else if ( node.data && this.response.results[this.decodeSpecialChars(node.data)] )
                      {
                        this.uniqDict[this.response.results[this.decodeSpecialChars(node.data)]] = node.data
                        node.data = this.response.results[this.decodeSpecialChars(node.data)]  
                      }  
                  }
                else
                  {
                    if ( node.data && this.uniqDict[node.data] )
                      {
                        block = this.uniqDict[node.data]
                        if ( !this.response.results[this.decodeSpecialChars(block)] )
                          {
                            isTrim = this.response.results[this.decodeSpecialChars(block.replace(/  +/g, ' ').trim())]
                            if ( isTrim )
                              {
                                this.tempUniqDict[isTrim]   = block
                                node.data                   = isTrim
                              }
                          }
                        else if ( node.data && this.response.results[this.decodeSpecialChars(block)] )
                          {
                            this.tempUniqDict[this.response.results[this.decodeSpecialChars(block)]] = block
                            node.data = this.response.results[this.decodeSpecialChars(block)]  
                          }
                      }
                  }
              }
          }  
    }
    
    /**
     * @param   object node
     * @returns void
     */
    
    this.translateAttribute = function(node)
    {
        var whitespace = /^\s+$/g;
        
        if ( node.nodeName == 'INPUT' )
          {              
            if ( node.getAttribute('value') && this.issetString(node.getAttribute('value')) )
                node.setAttribute('value', this.issetString(node.getAttribute('value')))
            if ( node.getAttribute('placeholder') && this.issetString(node.getAttribute('placeholder')) )
                node.setAttribute('placeholder', this.issetString(node.getAttribute('placeholder')))
          }
        else if ( node.nodeName == 'IMG' && node.getAttribute('alt') && this.issetString(node.getAttribute('alt')) )  
          {
            node.setAttribute('alt', this.issetString(node.getAttribute('alt')))
          }
          
        else if ( node.nodeName == 'META' )
          {
            if ( (node.getAttribute('name') == 'description' || node.getAttribute('name') =='keywords') && this.issetString(node.getAttribute('content')) )
                node.setAttribute('content', this.issetString(node.getAttribute('content')))
          }
    }
    
    /**
     * @param   {string} str
     * @returns {string}
     */
    
    this.issetString = function(str)
    {
        var whitespace = /^\s+$/g       

        str = str.replace(whitespace, '')       
        
        if ( str )
          { 
            if ( !this.complete )  
              {
                if ( !this.response.results[this.decodeSpecialChars(str)] )
                  {
                    isTrim = this.response.results[this.decodeSpecialChars(str.replace(/  +/g, ' ').trim())]
                    if ( isTrim )
                      {
                        this.uniqDict[isTrim] = node.data
                        str = isTrim
                      }
                  }
                else if ( str && this.response.results[this.decodeSpecialChars(str)] )
                  {
                    this.uniqDict[this.response.results[this.decodeSpecialChars(str)]] = str
                    str = this.response.results[this.decodeSpecialChars(str)]  
                  }  
              }
            else
              {
                if ( str && this.uniqDict[str] )
                  {
                    block = this.uniqDict[str]
                    if ( !this.response.results[this.decodeSpecialChars(block)] )
                      {
                        isTrim = this.response.results[this.decodeSpecialChars(block.replace(/  +/g, ' ').trim())]
                        if ( isTrim )
                          {
                            this.tempUniqDict[isTrim]   = block
                            str = isTrim
                          }
                      }
                    else if ( str && this.response.results[this.decodeSpecialChars(block)] )
                      {
                        this.tempUniqDict[this.response.results[this.decodeSpecialChars(block)]] = block
                        str = this.response.results[this.decodeSpecialChars(block)]  
                      }
                  }
              }
          }

        return str;
    }
    
    /**
     * Переводим текст на странице
     * 
     * @param    void
     * @returns  void
     */
    
    this.processTranslate = function()
    {
        var content         = document.getElementsByTagName('html')[0];
        
        if ( !this.complete )
          {
            document.getElementsByTagName('body')[0].style.display = this.style_body
            this.originalDOM  = document.documentElement.cloneNode(true);
          }
        
        if ( !this.complete )
          {
            this.recurseDomChildren(document.documentElement, true);   
            
            if ( this.htmlWidget )
                this.showChoice = true

            if ( this.showChoice )
                this.showAvailableLanguanges()
          }
        else
           {
             this.recurseDomChildren(document.documentElement, true);
             this.uniqDict = this.tempUniqDict
             //this.uniqDict = this.arraySwap(this.uniqDict)
           }  
         
        
        
	if ( !this.complete )
	    window.onload = function() {document.getElementsByTagName('body')[0].style.display = this.style_body; }
        
	this.complete = true
    }
    
    /**
     * Swap keys and val
     * 
     * @param  array array
     * @param  mixed overwriteNewValue
     * @param  mixed keepKey
     * @returns {Array|Boolean}
     */
    
    this.arraySwap = function(array,overwriteNewValue,keepKey){if(typeof(array)=="undefined"){return false;};if(typeof(array)!="object"){array=new Array(array);};var output=new Array();if(typeof(overwriteNewValue)=="undefined"){for(var k in array){output[array[k]]=k;}}else{if(!keepKey){for(var k in array){output[array[k]]=overwriteNewValue;}}else{for(var k in array){output[k]=overwriteNewValue;}};}return output;}

    /**
     * Special chars in HTML
     * 
     * @type   string
     * @return {string} decoded
    */ 
    
    this.decodeSpecialChars = function(html)
    {
        var a = document.createElement( 'a' ); a.innerHTML = html;
        return a.textContent;
    }
    
    /**
     * Показываем доступные языки
     * 
     * @param   void
     * @returns void
     */
    
    this.showAvailableLanguanges = function()
    {
        if ( this.showChoice )
          {
            this.htmlWidget = '<div style="position:fixed;left: 5%;bottom: 0;display:inline-block;" class="dropdown"><button onclick="getloc.openMenu()" style="background-color:#4CAF50;color:#fff;padding:16px;font-size:16px;border:none;cursor:pointer;} :hover:focus {background-color:#3e8e41}" id="showLang" class="dropbtn">'+this.lang+'</button><div id="myDropdown" class="dropdown-content" style="display:none;position:relative;background-color:#f9f9f9;min-width:160px;box-shadow:0 8px 16px 0 rgba(0,0,0,0.2)">'
            for ( var lang in this.response.available_languages )
            {
                this.htmlWidget += '<a href="#" onclick="getloc.changeLanguage(\''+lang+'\'); return false;" style="color:#000;padding:12px 16px;text-decoration:none;display:block; :hover{background-color:#f1f1f1}">'+lang+'</a>'
            }
            this.htmlWidget += '</div></div>'
            
            var tempElement = document.createElement('div');
            tempElement.innerHTML = this.htmlWidget
            var body        = document.getElementsByTagName('body')[0].appendChild(tempElement.firstChild);

            window.onclick = function(event)
            {
                if ( !event.target.matches('.dropbtn') )
                  {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for ( i = 0; i < dropdowns.length; i++ )
                    {
                      var openDropdown = dropdowns[i];
                      if ( openDropdown.style.display == 'block' )
                        openDropdown.style.display = 'none'
                    }
                  }
            }
          }

        this.showChoice = false;
    }
    
    /**
     * Смена языка
     * 
     * @param   string lang
     * @returns void
     */
    
    this.changeLanguage = function(lang)
    {
        this.lang = lang
        this.setCookie('saveLang', lang)
        
        this.detect_language()
        this.getTranslate()
        
        document.getElementById('showLang').innerHTML = lang;
    }
    
    /**
     * Открываем меню языков
     * 
     * @param   void
     * @returns void
     */
    
    this.openMenu = function()
    {
        document.getElementById("myDropdown").style.display = 'block';
    }
    
    /**
     * Получаем JSONP с запроса
     * 
     * @param   void
     * @returns void
     */
    
    this.setTranslate    = function(response)
    {
        if ( response.error )
          {
            window.console.log('error: ' + response.error.msg + ', code: ' + response.error.code)
            document.getElementsByTagName('body')[0].style.display = this.style_body
          }
        else
          {
            this.response = response
            this.processTranslate()
            
            window.console.log('GET JSON')
          }
    }
    
    /**
     * Получаем перевод через JSONP протокол
     * 
     * @param     void
     * @returns   void
     */
    
    this.getTranslate    = function()
    {
        window.console.log('REQUEST JSONP ')
        
        if ( lang = this.getCookie('saveLang') )
            this.lang = lang
        
        
        isLoaded = false
        style    = this.style_body

        var script      = document.createElement('script');
        script.src      = this.uri_api + 'secret='+this.secret+'&uri='+this.uri+'&lang='+this.lang+'&callback='+this.callback;
        script.src     += '&nocache=' + + (new Date()).getTime();
        script.async    = true;
        script.onerror  = function()
        {
            document.getElementsByTagName('body')[0].style.display = style
        }
        document.getElementsByTagName('HEAD')[0].appendChild(script);
    }
    
    /**
     * Запускаем в работу все методы
     * 
     * @param    void
     * @returns  void
     */
    
    this.run             = function()
    {
        if ( !getloc_off )
          {
            this.detect_language()
            this.getTranslate()
          }
    }
}
