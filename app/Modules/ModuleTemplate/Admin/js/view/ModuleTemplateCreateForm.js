Ext.define('ModuleTemplate.view.ModuleTemplateCreateForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.ModuleTemplate.view.ModuleTemplateCreateForm',
	
		requires:
		[
		"ModuleTemplate.view.field.ModuleTemplateLabelTemplateText"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "ModuleTemplate.view.field.ModuleTemplateLabelTemplateText"
			},
			{
			xtype: 'fieldset',
			title: 'HTML шаблона',
			collapsible: false,
				items:
				[
					{
					xtype: "codemirror",
					
					hideLabel: true,
					width: 835,
					height: 350,
					mode: "htmlmixed",
					
					name: "htmlTpl",
					reference: "htmlTpl",
					
					msgTarget: 'side',
					
						validator: function(value)
						{						
							if(Weborobot.Util.isLength(value, 0, 65000) == false)
							return "HTML шаблона должен содержать до 65000 символов!";
							else return true;
						}
					}
				]
			}
		]
	}
);