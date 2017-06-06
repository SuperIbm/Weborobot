Ext.define('Publication.view.field.PublicationImageFile', 
	{
    extend: 'Ext.form.field.File',
	xtype: "Publication.view.field.PublicationImageFile",
	
	fieldLabel: "Изображение:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "image",
	reference: "image",
	
	msgTarget: 'side'
	}
);
	