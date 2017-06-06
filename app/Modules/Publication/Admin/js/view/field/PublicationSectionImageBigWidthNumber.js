Ext.define('Publication.view.field.PublicationSectionImageBigWidthNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageBigWidthNumber",
	
	fieldLabel: "Ширина большого изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageBigWidth",
	reference: "imageBigWidth",
	
	msgTarget: 'side',
	
	value: 650,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Ширина большого изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	