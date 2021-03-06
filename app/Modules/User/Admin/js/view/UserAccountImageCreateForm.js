Ext.define('User.view.UserAccountImageCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.User.view.UserAccountImageCreateForm',
	itemId: "adress",
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "filefield",
			fieldLabel: "Изображение:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "image",
			reference: "image",
			
			msgTarget: 'side',
			
				validator: function(value)
				{						
					if(Weborobot.Util.isLength(value, 1) == false)
					return "Путь к изображению должен быть задан!";
					else return true;
				}	
			}		
		]
	}
);