Ext.define('Publication.view.field.PublicationSectionImageMiddleHeightNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageMiddleHeightNumber",
	
	fieldLabel: "Высота среднего изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageMiddleHeight",
	reference: "imageMiddleHeight",
	
	msgTarget: 'side',
	
	value: 0,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Высота среднего изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	