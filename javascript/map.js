    ymaps.ready(init);
    var myMap;

    function init(){     
        myMap = new ymaps.Map ("map", {
            center: [53.9376, 27.6318],
            zoom: 14
        });

        myPlacemark = new ymaps.Placemark([53.9376, 27.6318], { 
            hintContent: '', 
            balloonContent: '' 
        },{
          iconLayout: 'default#image',
          iconImageHref: 'img/label_map.png',
          iconImageSize: [155, 74]
        });

        myMap.geoObjects.add(myPlacemark);

        myMap.controls.add('zoomControl',{top: 10, right:5});
    }
