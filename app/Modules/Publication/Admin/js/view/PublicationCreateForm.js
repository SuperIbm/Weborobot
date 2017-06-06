Ext.define('Publication.view.PublicationCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Publication.view.PublicationCreateForm',
	
		requires:
		[
		"Publication.view.field.PublicationDateAddDate",
		"Publication.view.field.PublicationTimeAddTime",
		"Publication.view.field.PublicationTitleText",
		"Publication.view.field.PublicationLinkText",
		"Publication.view.field.PublicationAnonsTextarea",
		"Publication.view.field.PublicationImageFile",
		"Publication.view.field.PublicationQueryWordsText"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "Publication.view.field.PublicationDateAddDate"
			},
			{
			xtype: "Publication.view.field.PublicationTimeAddTime"
			},
			{
			xtype: "Publication.view.field.PublicationTitleText",
				listeners:
				{
					change: function(input, newValue, oldValue, eOpts)
					{
					input.up("window").down("textfield[name='link']").setValue(Weborobot.Util.toLatin(newValue).toLowerCase());
					}
				}
			},
			{
			xtype: "Publication.view.field.PublicationLinkText"
			},
			{
			xtype: "Publication.view.field.PublicationAnonsTextarea"
			},
			{
			xtype: "Publication.view.field.PublicationQueryWordsText"
			},
			{
			xtype: "Publication.view.field.PublicationImageFile"
			}
		]
	}
);