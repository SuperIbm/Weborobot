Ext.define('Filesystem.view.FilesystemFileCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Filesystem.view.FilesystemFileCreateForm',
	
		requires:
		[
		"Filesystem.view.field.FilesystemFileNameText"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "filefield",
			fieldLabel: "Файл:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "file",
			reference: "file",
			
			msgTarget: 'side',
			
				validator: function(value)
				{
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Путь к файлу должен быть определен!";
					else return true;
				}	
			},
			{
			xtype: "Filesystem.view.field.FilesystemFileNameText"
			}
		]
	}
);