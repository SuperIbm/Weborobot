Ext.define('Publication.view.field.PublicationSectionLabelPublicationText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Publication.view.field.PublicationSectionLabelPublicationText",
	
	fieldLabel: "Название раздела:<span class='needsForm'>*</span>",
			
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "labelSection",
	reference: "labelSection",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 150) == false)
			return "Название раздела должно содержать от 1 до 150 символов!";
			else return true;
		}
	}
);
	