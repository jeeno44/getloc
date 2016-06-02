#getloc_widget {
    position: fixed;
    bottom: 0;
    left: 27px;
    width: {{$widget->titles == 1 ? '115px' : '40px'}};
    text-align: center;
    color: {{$widget->theme == 'custom' ? $widget->color_active : '#80868f'}};
    font-size: 10px;
    line-height: 12px;
    padding: 13px 0;
    color: #fff;
    font-size: 14px;
    line-height: 14px;
    background: {{$widget->theme == 'custom' ? $widget->background_active : '#80868f'}}; {{-- Активный бг --}}
    border: none;
    cursor: pointer;
}

#getloc_widget.right-pos {
    left: auto;
    right: 27px;
}
#getloc_widget.lightness {
    background: #fff;
    color: {{$widget->theme == 'custom' ? $widget->color_active : '#333333'}};
    border: 1px solid #e6e6e6;
}

#getloc_wiget.abbreviations {width: 40px;}

.getloc_widget__menu {
    position: fixed;
    bottom: 0;
    left: 27px;
    width: 115px;
    background: {{$widget->theme == 'custom' ? $widget->background : '#2f353f'}};
    text-align: center;
    color:  {{$widget->theme == 'custom' ? $widget->color : '#80868f'}};
    font-size: 10px;
    line-height: 12px;
}
.getloc_widget__menu.right-pos {
    left: auto;
    right: 27px;
}
.getloc_widget__menu.lightness {
    background: #fff;
    border: 1px solid #e6e6e6;
}
.getloc_widget__menu a {
    display: block;
    padding: 13px 10px;
    color: {{$widget->theme == 'custom' ? $widget->color : '#fff'}};
    font-size: 14px;
    line-height: 14px;
    background: #434954;
}
.getloc_widget__menu.lightness a{
    background: #fff;
    color: #333333;
}
.getloc_widget__menu a:hover,
.getloc_widget__menu a.active {
    background: {{$widget->theme == 'custom' ? $widget->background_active : '#18baea'}};
}
.getloc_widget__menu.lightness a:hover,
.getloc_widget__menu.lightness a.active {
    background: #e6e6e6;
}
.getloc_widget__menu-full {
    display: block;
}
.getloc_widget__menu-abbreviations {
    display: none;
}
.getloc_widget__menu.abbreviations .getloc_widget__menu-full {
    display: none;
}
.getloc_widget__menu.abbreviations .getloc_widget__menu-abbreviations {
    display: block;
}
.getloc_widget__crafted {
    padding: 4px 1px;
    background: #2f353f;
}
.getloc_widget__menu.lightness .getloc_widget__crafted {
    margin: 0 -1px -1px;
}
