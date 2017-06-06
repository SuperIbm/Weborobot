Ext.define('Publication.view.PublicationCommentCreateForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Publication.view.PublicationCommentCreateForm',
	
		requires:
		[
		"Publication.view.field.PublicationCommentNameText",
		"Publication.view.field.PublicationCommentEmailText",
		"Publication.view.field.PublicationCommentUrlText",
		"Publication.view.field.PublicationCommentCommentTextarea",
		"Publication.view.field.PublicationCommentDateAddDate",
		"Publication.view.field.PublicationCommentTimeAddDate",
		"Publication.view.field.PublicationCommentImageFile"
		],
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: true,
	frame: false,
	
		items:
		[
			{
			xtype: "comboBoxStatus",

				store: new Ext.data.ArrayStore
				(
					{
						fields:
						[
						"name"
						],
						data:
						[
							[
							"Активен"
							],
							[
							"Не проверен"
							],
							[
							"Не активен"
							]
						]
					}
				)
			},
			{
			xtype: "Publication.view.field.PublicationCommentNameText"
			},
			{
			xtype: "Publication.view.field.PublicationCommentEmailText"
			},
			{
			xtype: "Publication.view.field.PublicationCommentUrlText"
			},
			{
			xtype: "Publication.view.field.PublicationCommentDateAddDate"
			},
			{
			xtype: "Publication.view.field.PublicationCommentTimeAddDate"
			},
			{
			xtype: "Publication.view.field.PublicationCommentCommentTextarea"
			},
			{
			xtype: "Publication.view.field.PublicationCommentImageFile"
			}
		]
	}
);