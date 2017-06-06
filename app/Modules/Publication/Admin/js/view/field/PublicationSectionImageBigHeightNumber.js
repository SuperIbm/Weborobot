Ext.define('Publication.view.field.PublicationSectionImageBigHeightNumber', 
	{
    extend: 'Ext.form.field.Number',
	xtype: "Publication.view.field.PublicationSectionImageBigHeightNumber",
	
	fieldLabel: "Высота большого изображения:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 250,
	width: 450,
	
	name: "imageBigHeight",
	reference: "imageBigHeight",
	
	msgTarget: 'side',
	
	value: 0,
	
		validator: function(value)
		{				
			if(Weborobot.Util.isInteger(value, true, 1, 4) == false)
			return "Высота большого изображения должна содержать положительное целое число!";
			else return true;
		}
	}
);
	