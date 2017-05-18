Ext.define('Page.view.field.PageRedirectText',
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageRedirectText",
	
	fieldLabel: "URL переадресации:",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "redirect",
	reference: "redirect",

	msgTarget: 'side',

        validator: function(value)
        {
            if(Weborobot.Util.isUrl(value, false) == false)
                return "Поле адрес переадресации должно содержать корректный URL!";
            else return true;
        }
	}
);
	