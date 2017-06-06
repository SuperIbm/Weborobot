Ext.define('Publication.view.field.PublicationSectionImageMiddleWidthNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageMiddleWidthNumber",
	
	fieldLabel: "Ширина среднего изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageMiddleWidth",
	reference: "imageMiddleWidth",
	
	msgTarget: 'side',
	
	value: 200,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Ширина среднего изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	