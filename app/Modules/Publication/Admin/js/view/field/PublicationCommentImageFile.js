Ext.define('Publication.view.field.PublicationCommentImageFile',
	{
    extend: 'Ext.form.field.File',
	xtype: "Publication.view.field.PublicationCommentImageFile",
	
	fieldLabel: "Изображение:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "image",
	reference: "image",
	
	msgTarget: 'side'
	}
);
	