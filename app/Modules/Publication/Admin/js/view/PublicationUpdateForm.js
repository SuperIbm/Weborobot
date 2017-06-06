Ext.define('Publication.view.PublicationUpdateForm', 
	{
    extend: 'Publication.view.PublicationCreateForm',
	alias: 'widget.Publication.view.PublicationUpdateForm',
	
		requires:
		[
		"Publication.view.PublicationCreateForm"
		],
		
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
			}
		]
	}
);