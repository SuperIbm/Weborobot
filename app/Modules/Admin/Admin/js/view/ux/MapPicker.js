// Подгрузим саму библиотеку
Ext.Loader.loadScript
(
	{
	url: "https://api-maps.yandex.ru/2.1/?lang=ru_RU"	
	}
);


Ext.define('Admin.view.ux.MapPicker',
	{
    extend: 'Ext.form.field.Text',
	xtype: 'mappicker',
	alias: 'widget.mappicker',
	
	editable: true,
	
		triggers:
		{
			searcher:
			{
			cls: 'x-form-select-trigger',			
				handler: function()	
				{
				var thisObj = this;
				
					var Window = new Ext.Window
					(
						{
						title: thisObj.windowTitle,
						width: 900,
						height: 500,
						modal: true,
						minimizable: false,
						maximizable: false,
						resizable: false
						}
					).show();
					
					if(thisObj.getValue())
					{
					var coords = thisObj.getValue().split(", ");
					coords[0] *= 1;
					coords[1] *= 1;	
					}
					else var coords = [46, 22];
					
					var myMap = new ymaps.Map($("#" + Window.id + " .x-autocontainer-innerCt").get(0), 
						{
						center: coords,
						zoom: thisObj.getValue() ? 17 : 3,
							controls: 
							[
							"geolocationControl", 
							"searchControl",
							"trafficControl",
							"typeSelector",
							"zoomControl"
							]
						}
					);
					
				myMap.cursors.push('pointer');
					
					if(thisObj.getValue())
					{
						myMap.geoObjects.add
						(
							new ymaps.Placemark
							(
								coords, 
								{
								balloonContentBody: thisObj.balloonContentBody + ": <br />" + coords[0].toPrecision(6) + ", " + coords[1].toPrecision(6)
								}
							)
						);
					}
					
					myMap.events.add('click', 
						function(e)
						{
						var coords = e.get('coords');
						thisObj.setValue(coords[0].toPrecision(6) + ", " + coords[1].toPrecision(6));
						Window.close();
						}
					);
				}
			}
		},
		validateValue: function(value)
		{
			var status = this.callParent
			(
				[
				value
				]
			);
		
			if(!status) return false;
			if(value.length == 0) return true;
			
		var re = /^(\d+\.?\d*, \d+\.?\d*){1}$/;
		
			if(!value.match(re))
			{
			this.markInvalid(this.invalidText);
			return false;
			}
		
		return true;
		},
		search: function(query)
		{
		var thisObj = this;
		
			$.ajax
			(
				{
				url: "http://geocode-maps.yandex.ru/1.x/?geocode=" + query + "&format=json&results=1",
				dataType: "json",
					success: function(result, success)
					{									
						if(result["response"]["GeoObjectCollection"]["metaDataProperty"]["GeocoderResponseMetaData"]["found"] != 0)
						{
						var point = result["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"].split(" ");	
						
						thisObj.setValue(point[1] + ", " + point[0]);
						}
						else thisObj.setValue("");	
					},
					error: function()
					{
					thisObj.setValue("");		
					}
				}
			);
		}
	}
);