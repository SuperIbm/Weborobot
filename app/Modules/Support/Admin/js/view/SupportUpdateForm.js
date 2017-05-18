Ext.define('Support.view.SupportUpdateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Support.view.SupportUpdateForm',
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "textfield",
			fieldLabel: "Имя администратора:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "fio",
			reference: "fio",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1, 250) == false)
					return "Имя должно содержать от 1 до 250 символов!";
					else return true;
				}
			},
			{
			xtype: "textfield",
			fieldLabel: "E-mail администратора:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "email",
			reference: "email",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isEmail(value, true, true) == false)
					return "Проверьте корректность введенной электронной почты!";
					else return true;
				}
			},
		]
	}
);