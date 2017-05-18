Ext.define('User.view.field.UserAccountSiteText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "User.view.field.UserAccountSiteText",
	
	fieldLabel: "Сайт:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "site",
	ref: "site",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isUrl(value, false) == false)
			return "Ссылка на сайт имеет некорректный формат!";
			else return true;
		}
	}
);
	