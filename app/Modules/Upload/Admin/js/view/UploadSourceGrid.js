Ext.define('Upload.view.UploadSourceGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Upload.view.UploadSourceGrid',
	
		requires:
		[
		"Upload.view.field.UploadSourceLoginText",
		"Upload.view.field.UploadSourcePasswordText",
		"Upload.view.field.UploadSourceUrlText"
		],
	
	name: "Upload",
	store: 'UploadSource',
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'UploadSource',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idUploadSource',
			width: "8%",
			filter: 'number'
			},
			{
			header: 'Логин',
			dataIndex: 'login',
			width: "32%",
			filter: 'string',
				editor: 
				{
				xtype: "Upload.view.field.UploadSourceLoginText",
				hideLabel: true	
				}
			},
			{
			header: 'Пароль',
			dataIndex: 'passwordHash',
			filter: 'string',
			hidden: true,
				editor: 
				{
				xtype: "Upload.view.field.UploadSourcePasswordText",
				hideLabel: true	
				}
			},
			{
			header: 'Источник обновления',
			dataIndex: 'url',
			width: "45%",
			filter: 'string',
				editor: 
				{
				xtype: "Upload.view.field.UploadSourceUrlText",
				hideLabel: true	
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: "15%",
			filter: 'boolean',
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
			hidden: Admin.getApplication().Access.is("Upload", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("Upload", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("Upload", "isDestroy") == true ? false : true
			}
		
		this.callParent();
		}
	}
);