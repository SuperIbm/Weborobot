Ext.define('User.view.UserAccountCreateFormImage', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountCreateFormImage',
	itemId: "image",
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "filefield",
			fieldLabel: "Изображение:",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "image",
			reference: "image",
			
			msgTarget: 'side'	
			}	
		]
	}
);