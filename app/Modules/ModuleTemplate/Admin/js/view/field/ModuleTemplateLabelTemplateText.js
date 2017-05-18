Ext.define('ModuleTemplate.view.field.ModuleTemplateLabelTemplateText',
	{
    extend: 'Ext.form.field.Text',
	xtype: "ModuleTemplate.view.field.ModuleTemplateLabelTemplateText",
	
	fieldLabel: "Название шаблона:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "labelTemplate",
	reference: "labelTemplate",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 150) == false)
			return "Название шаблона должно содержать от 1 до 150 символов!";
			else return true;
		}
	}
);
	