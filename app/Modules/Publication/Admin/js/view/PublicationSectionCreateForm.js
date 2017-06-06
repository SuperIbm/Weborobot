Ext.define('Publication.view.PublicationSectionCreateForm', 
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Publication.view.PublicationSectionCreateForm',
	
		requires:
		[
		"Publication.view.field.PublicationSectionLabelPublicationText",
		
		"Publication.view.field.PublicationSectionImageSmallWidthNumber",
		"Publication.view.field.PublicationSectionImageSmallHeightNumber",
		
		"Publication.view.field.PublicationSectionImageMiddleWidthNumber",
		"Publication.view.field.PublicationSectionImageMiddleHeightNumber",
		
		"Publication.view.field.PublicationSectionImageBigWidthNumber",
		"Publication.view.field.PublicationSectionImageBigHeightNumber"
		],
	
	padding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus"
			},
			{
			xtype: "Publication.view.field.PublicationSectionLabelPublicationText"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageSmallWidthNumber"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageSmallHeightNumber"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageMiddleWidthNumber"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageMiddleHeightNumber"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageBigWidthNumber"
			},
			{
			xtype: "Publication.view.field.PublicationSectionImageBigHeightNumber"
			}
		]
	}
);