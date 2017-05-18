Ext.define('Filesystem.view.FilesystemFileGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Filesystem.view.FilesystemFileGrid',
	
		requires:
		[
		"Filesystem.view.field.FilesystemFileNameText"
		],
	
	name: "Filesystem",
	store: 'File',
	
	region: 'center',
	split: true,
	forceFit: true,
	
	
	title: "Файлы",
	margin: '5 5 5 0',
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'gridviewdragdrop',
			ddGroup: "Filesystem.view.FilesystemFileAndDir",
			enableDrop: false
			}
		},
	
		columns:
		[
			{
			dataIndex: 'type',
			width: '7%',
				renderer: function(value, meta, record)
				{
					if(value == "dir") return "<img src='app/Modules/Admin/Admin/images/icon_folder.png' />";
					else if(value == "file")
					{
					var pathIcon = Admin.getApplication().getPathToIcoByFormat(record.get("extension"));
					return "<img src='" + pathIcon + "' />"
					}
				}
			},
			{
			header: 'Название',
			dataIndex: 'nameFull',
			width: "16%",
			filter: 'string',
				editor:
				{
				xtype: "Filesystem.view.field.FilesystemFileNameText",
				hideLabel: true,
					validator: function(value)
					{				
						if(Weborobot.Util.isLength(value, 1, 255) == false)
						return "Название файла должно содержать до 255 символов!";
						else return true;
					}
				}
			},
			{
			header: 'Полный путь',
			dataIndex: 'path',
			hidden: true,
			filter: 'string'
			},
			{
			header: 'Расширение',
			dataIndex: 'extension',
			hidden: true,
			filter: 'string'
			},
			{
			header: 'Размер',
			dataIndex: 'size',
			width: "16%",
			filter: 'number',
				renderer: function(value)
				{	
					if(value == 0) return "";		
					else if(value >= (1024 * 1024)) return (value / 1024 / 1024).round(2) + " Мб.";
					else if(value >= 1024) return (value / 1024).round(2) + " Кб.";
					else return value.round(2) + " байт.";	
				}
			},
			{
			header: 'Права',
			dataIndex: 'mode',
			width: "16%",
			filter: 'string'
			},
			{
			header: 'Владелец',
			dataIndex: 'uid',
			width: "15%",
			filter: 'string'
			},
			{
			header: 'Группа',
			dataIndex: 'gid',
			width: "15%",
			filter: 'string'
			},
			{
			header: 'Дата создания',
			dataIndex: 'dateCreate',
			hidden: true,
				filter:
				{
				type: 'date',
				dateFormat: "Y-m-d"
				}
			},
			{
			header: 'Дата изменения',
			dataIndex: 'dateModify',
			width: "15%",
				filter:
				{
				type: 'date',
				dateFormat: "Y-m-d"
				}
			}
		],
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить файлы',
			itemId: 'refresh'
			}
		],
		listeners:
		{
			afterEditUpdate: function(success, operation, editor, context)
			{			
				if(success == true)
				{
				var result = Ext.decode(operation.getResponse().responseText);
				
				context.record.setId(result.data.path);
				context.record.set("path", result.data.path);
				context.record.set("name", result.data.name);
				}				
			}
		},
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Загрузить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isCreate")
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Filesystem", "isDestroy")
			};
			
		this.callParent();
		var thisObj = this;
		
			if(this.getStore().isLoaded())
			{			
				this.getStore().on("load",
					function()
					{
					var tree = this.up("panel").down("treepanel");
					var path = this.getStore().getProxy().getExtraParams()["path"];
					
						if(path)
						{
						var record = tree.getStore().getById(path);
						
							if(record)
							{
							tree.getSelectionModel().select(record, null, true);
							this.setTitle("Файлы папки: " + path);
							
							this.getButtonCreate().setDisabled(false);	
							this.getMenuItemCreate().setDisabled(false);
							}
						}
						else tree.getSelectionModel().select(tree.getStore().getRoot());
					},
					this,
					{
					single: true	
					}
				);
				
			this.getStore().load();
			}
			else this.getStore().load();
		}
	}
);