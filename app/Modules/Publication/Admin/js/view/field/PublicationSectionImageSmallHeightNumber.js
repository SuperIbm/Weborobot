Ext.define('Publication.view.field.PublicationSectionImageSmallHeightNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageSmallHeightNumber",
	
	fieldLabel: "Высота маленького изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageSmallHeight",
	reference: "imageSmallHeight",
	
	msgTarget: 'side',
	
	value: 120,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Высота маленького изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	