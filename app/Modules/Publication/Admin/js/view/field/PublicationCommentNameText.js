Ext.define('Publication.view.field.PublicationCommentNameText',
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationCommentNameText",
	
	fieldLabel: "Имя:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "name",
	reference: "name",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 150) == false)
			return "Имя должно содержать от 1 до 150 символов!";
			else return true;
		}
	}
);
	