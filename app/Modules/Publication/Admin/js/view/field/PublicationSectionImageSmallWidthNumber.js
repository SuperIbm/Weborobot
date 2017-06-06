Ext.define('Publication.view.field.PublicationSectionImageSmallWidthNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageSmallWidthNumber",
	
	fieldLabel: "Ширина маленького изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageSmallWidth",
	reference: "imageSmallWidth",
	
	msgTarget: 'side',
	
	value: 120,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Ширина маленького изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	