Ext.define('Publication.view.PublicationGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Publication.view.PublicationGrid',
	
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
	
	name: "Publication",
	store: 'Publication',
	
	region: 'center',
	split: true,	
	forceFit: true,
	
	title: "Публикации",
	margin: '5 0 0 0',
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'gridviewdragdrop',
			ddGroup: "Publication.view.PublicationGrid",
			enableDrop: false
			}
		},
		
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Publication',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idPublication',
			width: "8%",
			filter: 'numeric'
			},
			{
			header: 'Изображение',
			dataIndex: 'idImageSmall',
			xtype: 'imagecolumn',
			width: "24%",
			filter: "image"
			},
			{
			header: 'Раздел',
			dataIndex: 'labelSection'
			},
			{
			header: 'Дата добавления',
			dataIndex: 'dateAdd',
			xtype: 'datecolumn',
			format: "j F Y, H:i",
			width: "25%",
				filter:
				{
				type: 'date',
				dateFormat: "Y-m-d"
				}
			},
			{
			header: 'Заголовок',
			dataIndex: 'title',
			width: "28%",
			filter: 'string',
				editor: 
				{
				xtype: "Publication.view.field.PublicationTitleText",
				hideLabel: true	
				}
			},
			{
			header: 'Ссылка',
			dataIndex: 'link',
			filter: 'string',
			hidden: true,
				editor: 
				{
				xtype: "Publication.view.field.PublicationLinkText",
				hideLabel: true	
				}
			},
			{
			header: 'Анонс',
			dataIndex: 'anons',
			filter: 'string',
			hidden: true,
				editor: 
				{
				xtype: "Publication.view.field.PublicationAnonsTextarea",
				hideLabel: true	
				}
			},
			{
			header: 'Ключевые слова',
			dataIndex: 'queryWords',
			hidden: true,
			sortable: false,
				editor: 
				{
				xtype: "Publication.view.field.PublicationQueryWordsText",
				hideLabel: true	
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			filter: 'boolean',
			width: "15%",
				editor:
				{
				xtype: 'comboBoxStatus',
				hideLabel: true
				}
			}
		],
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			disabled: true,
			hidden: !Admin.getApplication().Access.is("Publication", "isCreate")
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
		var thisObj = this;
		
			if(this.getStore().isLoaded())
			{
				this.getStore().on("load",
					function()
					{
					var tree = this.up("panel").down("treepanel");
					var idPublicationSection = this.getStore().getProxy().getExtraParams()["idPublicationSection"];
					
						if(idPublicationSection)
						{
						var record = tree.getStore().getById(idPublicationSection);
						tree.getSelectionModel().select(record, null, true);
						
							if(record.getId() != 0)
							{
								if(this.getButtonCreate())
								{
								this.getButtonCreate().setDisabled(false);	
								this.getMenuItemCreate().setDisabled(false);
								}
							
								if(tree.getButtonCreate())
								{
								tree.getButtonCreate().setDisabled(false);	
								tree.getMenuItemCreate().setDisabled(false);
								}
								
								if(tree.getButtonUpdate())
								{
								tree.getButtonUpdate().setDisabled(false);	
								tree.getButtonUpdate().setDisabled(false);
								}
								
								if(tree.getButtonDestroy())
								{
								tree.getButtonDestroy().setDisabled(false);	
								tree.getButtonDestroy().setDisabled(false);
								}
							}
							else
							{
								if(tree.getButtonCreate())
								{
								tree.getButtonCreate().setDisabled(false);	
								tree.getMenuItemCreate().setDisabled(false);
								}
							}
						
						this.setTitle("Публикации: " + record.getData().labelSection);
						}
						else tree.getSelectionModel().select(tree.getStore().getRoot());
					},
					this,
					{
					single: true	
					}
				);
			}
		}
	}
);