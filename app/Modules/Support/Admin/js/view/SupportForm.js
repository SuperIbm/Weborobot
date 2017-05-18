Ext.define('Support.view.SupportForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Support.view.SupportForm',
	
	bodyBorder: false,
	border: false,
	frame: false,
	scrollable: true,
	bodyPadding: 15,
	
		items:
		[
			{
			xtype: "textfield",
			fieldLabel: "Тема сообщения:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "theme",
			reference: "theme",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1, 255) == false)
					return "Тема сообщения должна содержать от 1 до 255 символов!";
					else return true;
				}
			},
			{
			xtype: "textfield",
			fieldLabel: "Представьтесь:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "fio",
			reference: "fio",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 1, 255) == false)
					return "Имя должно содержать от 1 до 255 символов!";
					else return true;
				}
			},
			{
			xtype: "textfield",
			fieldLabel: "Ваш email:<span class='needsForm'>*</span>",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "email",
			reference: "email",
			
			msgTarget: 'side',
			value: Admin.getApplication().Access.getUser("email"),
			
				validator: function(value)
				{				
					if(Weborobot.Util.isEmail(value, true, true) == false)
					return "Проверьте корректность введенной электронной почты!";
					else return true;
				}
			},
			{
			xtype: "textMasked",
			fieldLabel: "Ваш телефон:",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "telephone",
			reference: "telephone",
			mask: "+7 (999) 999-99-99",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isLength(value, 0, 18) == false)
					return "Проверьте корректность введенного номера телефона!";
					else return true;
				}
			},
			{
			xtype: "filefield",
			fieldLabel: "Прикрепить файл:",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "file",
			reference: "file",
			
			msgTarget: 'side'	
			},
			{
			xtype: "textfield",
			fieldLabel: "Страница с ошибкой:",
			
			labelSeparator: "",
			labelWidth: 160,
			width: 450,
			
			name: "url",
			reference: "url",
			
			msgTarget: 'side',
			
				validator: function(value)
				{				
					if(Weborobot.Util.isUrl(value, false) == false)
					return "Проверьте корректность введенной ссылки!";
					else return true;
				}
			},
			{
			xtype: 'fieldset',
			title: 'Текст сообщения:<span class="needsForm">*</span>',
			collapsible: false,
				items:
				[
					{
					xtype: "textareafield",
					
					hideLabel: true,
					width: "100%",
					height: 210,
					
					name: "message",
					reference: "message",
					
					msgTarget: 'side',
					
						validator: function(value)
						{						
							if(Weborobot.Util.isLength(value, 1, 5000) == false)
							return "Текст сообщения должен содержать от 1 до 5000 символов!";
							else return true;
						}
					}
				]
			}
		]
	}
);