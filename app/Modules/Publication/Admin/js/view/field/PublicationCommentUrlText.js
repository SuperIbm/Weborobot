Ext.define('Publication.view.field.PublicationCommentUrlText',
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationCommentUrlText",
	
	fieldLabel: "Сайт:",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "url",
	ref: "url",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isUrl(value, false) == false)
			return "Ссылка на сайт имеет некорректный формат!";
			else return true;
		}
	}
);
	