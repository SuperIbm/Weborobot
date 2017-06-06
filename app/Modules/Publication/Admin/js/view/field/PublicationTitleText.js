Ext.define('Publication.view.field.PublicationTitleText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationTitleText",
	
	fieldLabel: "Заголовок:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "title",
	reference: "title",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return "Заголовок должен содержать от 1 до 255 символов!";
			else return true;
		}
	}
);
	