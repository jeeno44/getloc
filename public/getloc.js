function getloc(settings)
{
    this.auto_detected = settings['auto_detected'];
    this.lang          = settings['lang'];
    this.uri           = window.location.href;
    this.secret        = settings['secret'];
    this.uri_api       = 'http://scan.get-loc.ru/api/translate?';
    this.callback      = 'getloc.setTranslate';
    this.response      = '';
    this.showChoice    = true;
    this.htmlWidget    = '';
    this.originalCont  = '';
    this.complete      = false;
    this.source        = settings['source']
    
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
     * Переводим текст на странице
     * 
     * @param    void
     * @returns  void
     */
    
    this.processTranslate = function()
    {
        var content         = document.getElementsByTagName('html')[0];
        
        if ( !this.complete )
            this.originalCont = content.innerHTML;
        
        if ( !this.complete )
            for ( var original in this.response.results ) 
                content.innerHTML = content.innerHTML.replace(new RegExp(this.decodeSpecialChars(original), 'g'), this.response.results[original]);
        else
           {
            var temp_content = this.originalCont

            for ( var original in this.response.results ) 
                this.originalCont = this.originalCont.replace(new RegExp(this.decodeSpecialChars(original), 'g'), this.response.results[original]);

            document.getElementsByTagName('html')[0].innerHTML = this.originalCont
            this.originalCont = temp_content
           }  
          
        
        
        if ( this.htmlWidget )
            this.showChoice = true
        
        if ( this.showChoice )
            this.showAvailableLanguanges()
        
        this.complete = true;
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
        this.detect_language()
        this.getTranslate()        
    }
}