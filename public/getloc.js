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
    var css    = 'body {display: none;}',
        head   = document.head || document.getElementsByTagName('head')[0],
        style  = document.createElement('style');
    style.type = 'text/css'

    if ( style.styleSheet )
        style.styleSheet.cssText = css;
    else
        style.appendChild(document.createTextNode(css));

    head.appendChild(style)

    window.console.log('insert css')
  }


function getloc(settings)
{
    this.auto_detected = settings['auto_detected']
    this.lang          = settings['lang']
    this.uri           = window.location.href
    this.secret        = settings['secret']
    this.uri_api       = 'http://api.get-loc.ru/translate?'
    this.callback      = 'getloc.setTranslate'
    this.response      = ''
    this.showChoice    = true
    this.htmlWidget    = ''
    this.originalCont  = ''
    this.complete      = false
    this.source        = settings['source']
    this.saveLang      = settings['saveLang']
    
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
            document.getElementsByTagName('body')[0].style.display = 'block'
            this.originalCont  = content.innerHTML;
          }
        
        if ( !this.complete )
            for ( var original in this.response.results ) {
                console.log(original);
                content.innerHTML = content.innerHTML.replace(new RegExp(this.decodeSpecialChars(original), 'g'), this.response.results[original]);
            }

        else
           {
            var temp_content  = this.originalCont

            for ( var original in this.response.results )
                this.originalCont = this.originalCont.replace(new RegExp(this.decodeSpecialChars(original), 'g'), this.response.results[original]);

            document.getElementsByTagName('html')[0].innerHTML = this.originalCont
            this.originalCont = temp_content
           }  
          
        if ( this.htmlWidget )
            this.showChoice = true
        
        if ( this.showChoice )
            this.showAvailableLanguanges()
        
	if ( !this.complete )
	    window.onload = function() {document.getElementsByTagName('body')[0].style.display = 'block'}
        
	this.complete = true
    }
    
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
            var body = document.getElementsByTagName('body')[0]
            body.innerHTML = body.innerHTML + this.htmlWidget

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
            window.console.log('error: ' + response.error.message + ', code: ' + response.error.code)
            document.getElementsByTagName('body')[0].style.display = 'block'
          }
        
        this.response = response
        this.processTranslate()
        
        window.console.log('GET JSON')
    }
    
    /**
     * Получаем перевод через JSONP протокол
     * 
     * @param     void
     * @returns   void
     */
    
    this.getTranslate    = function()
    {
        window.console.log('REQUEST JSONP')
        
        if ( lang = this.getCookie('saveLang') )
            this.lang = lang
        
        var script      = document.createElement('script');
        script.src      = this.uri_api + 'secret='+this.secret+'&uri='+this.uri+'&lang='+this.lang+'&callback='+this.callback;
        script.src     += '&nocache=' + + (new Date()).getTime();
        script.async    = true;
        
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
