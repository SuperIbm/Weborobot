Ext.define('Publication.view.PublicationCommentUpdateForm',
	{
    extend: 'Publication.view.PublicationCommentCreateForm',
	alias: 'widget.Publication.view.PublicationCommentUpdateForm',
	
		requires:
		[
		"Publication.view.PublicationCommentCreateForm"
		],

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
			}
		]
	}
);