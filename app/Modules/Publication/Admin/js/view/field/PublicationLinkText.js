Ext.define('Publication.view.field.PublicationLinkText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationLinkText",
	
	fieldLabel: "Ссылка:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "link",
	reference: "link",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLatinica(value, 1, 255) == false)
			return "Название ссылки должно содержать только цифры или латиницу, длиной от 1 до 255 символов!";
			else return true;
		}
	}
);
	