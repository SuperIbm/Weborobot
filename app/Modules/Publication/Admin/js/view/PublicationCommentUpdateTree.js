Ext.define('Publication.view.PublicationCommentUpdateTree',
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Publication.view.PublicationCommentUpdateTree',

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
	
	name: "PublicationComment",
	store: "PublicationCommentTree",
	canDeleteFirstNode: false,
	canUpdateFirstNode: false,

	sortableColumns: false,
	border: true,
	rootVisible: true,
	filter: true,
	useArrows: true,
	
		columns:
		[
			{
			text: 'ID',
			width: "7%",
			dataIndex: 'idPublicationComment'
			},
			{
			xtype: 'treecolumn',
			text: 'Имя',
			width: "26%",
			dataIndex: 'name',
				editor: 
				{
				xtype: "Publication.view.field.PublicationCommentNameText",
				hideLabel: true	
				}
			},
			{
			header: 'Изображение',
			dataIndex: 'idImageSmall',
			xtype: 'imagecolumn',
			width: "26%"
			},
			{
			text: 'E-mail',
			dataIndex: 'email',
			hidden: true,
				editor: 
				{
				xtype: "Publication.view.field.PublicationCommentEmailText",
				hideLabel: true	
				}
			},
			{
			text: 'Ссылка',
			dataIndex: 'url',
			hidden: true,
				editor:
				{
				xtype: "Publication.view.field.PublicationCommentUrlText",
				hideLabel: true
				}
			},
			{
			text: 'Комметарий',
			dataIndex: 'comment',
			hidden: true,
				editor:
				{
				xtype: "Publication.view.field.PublicationCommentCommentTextarea",
				hideLabel: true
				}
			},
			{
			header: 'Дата добавления',
			dataIndex: 'dateAdd',
			xtype: 'datecolumn',
			format: "j F Y, H:i",
			width: "26%"
			},
			{
			text: 'IP',
			dataIndex: 'ip',
			hidden: true
			},
			{
			text: 'Статус',
			width: "15%",
			dataIndex: 'status',
				editor:
				{
				xtype: 'comboBoxStatus',
				hideLabel: true,
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
				}
			}
		],
	
		initComponent: function()
		{
			this.buttonCreate =
			{
			text: "Добавить",
			hidden: !Admin.getApplication().Access.is("Publication", "isUpdate")
			};

			this.buttonUpdate =
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Publication", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Publication", "isDestroy")
			};
		
		this.callParent();
		}
	}
);