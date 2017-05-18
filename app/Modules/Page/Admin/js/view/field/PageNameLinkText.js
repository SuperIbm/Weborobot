Ext.define('Page.view.field.PageNameLinkText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Page.view.field.PageNameLinkText",
	
	fieldLabel: "Ссылка:<span class='needsForm'>*</span>",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "nameLink",
	reference: "nameLink",
	
	msgTarget: 'side',
	
		validator: function(value)
		{
			if(Weborobot.Util.isLatinica(value, 1, 255) == false)
			return "Название ссылки должно содержать только цифры или латиницу, длиной от 1 до 255 символов!";
			else return true;
		}
	}
);
	