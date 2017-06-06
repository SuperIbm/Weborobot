Ext.define('Publication.view.field.PublicationCommentCommentTextarea',
	{
    extend: 'Ext.form.field.TextArea',
	xtype: "Publication.view.field.PublicationCommentCommentTextarea",
	
	fieldLabel: "Комментарий:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 700,
	height: 200,
	
	name: "comment",
	reference: "comment",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 5000) == false)
			return "Анонс должен быть длиной от 1 до 5000 символов.";
			else return true;
		}
	}
);
	