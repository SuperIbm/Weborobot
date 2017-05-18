Ext.define('PageTemplate.view.field.PageTemplateNameTemplateText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "PageTemplate.view.field.PageTemplateNameTemplateText",
	
	fieldLabel: "Папка шаблона:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "nameTemplate",
	reference: "nameTemplate",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
		var valueLow = value.toLowerCase();
		
			if(valueLow == "error_unfound" || valueLow == "error_system" || valueLow == "admin")
			{
			return "Не допускается использовать имена: error_unfound, error_system, admin";
			}
			
			if(Weborobot.Util.isLatinica(value, 1, 100, true) == false)
			return "Папка шаблона должна содержать только латиницу или цифры, написанные в нижнем регистре!";
			else return true;
		}
	}
);
	