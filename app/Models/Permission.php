<?php

namespace Pterodactyl\Models;

use Illuminate\Support\Collection;

class Permission extends Model
{
    /**
     * The resource name for this model when it is transformed into an
     * API representation using fractal.
     */
    public const RESOURCE_NAME = 'subuser_permission';

    /**
     * Constants defining different permissions available.
     */
    public const ACTION_WEBSOCKET_CONNECT = 'websocket.connect';
    public const ACTION_CONTROL_CONSOLE = 'control.console';
    public const ACTION_CONTROL_START = 'control.start';
    public const ACTION_CONTROL_STOP = 'control.stop';
    public const ACTION_CONTROL_RESTART = 'control.restart';

    public const ACTION_DATABASE_READ = 'database.read';
    public const ACTION_DATABASE_CREATE = 'database.create';
    public const ACTION_DATABASE_UPDATE = 'database.update';
    public const ACTION_DATABASE_DELETE = 'database.delete';
    public const ACTION_DATABASE_VIEW_PASSWORD = 'database.view_password';

    public const ACTION_SCHEDULE_READ = 'schedule.read';
    public const ACTION_SCHEDULE_CREATE = 'schedule.create';
    public const ACTION_SCHEDULE_UPDATE = 'schedule.update';
    public const ACTION_SCHEDULE_DELETE = 'schedule.delete';

    public const ACTION_USER_READ = 'user.read';
    public const ACTION_USER_CREATE = 'user.create';
    public const ACTION_USER_UPDATE = 'user.update';
    public const ACTION_USER_DELETE = 'user.delete';

    public const ACTION_BACKUP_READ = 'backup.read';
    public const ACTION_BACKUP_CREATE = 'backup.create';
    public const ACTION_BACKUP_DELETE = 'backup.delete';
    public const ACTION_BACKUP_DOWNLOAD = 'backup.download';
    public const ACTION_BACKUP_RESTORE = 'backup.restore';

    public const ACTION_ALLOCATION_READ = 'allocation.read';
    public const ACTION_ALLOCATION_CREATE = 'allocation.create';
    public const ACTION_ALLOCATION_UPDATE = 'allocation.update';
    public const ACTION_ALLOCATION_DELETE = 'allocation.delete';

    public const ACTION_FILE_READ = 'file.read';
    public const ACTION_FILE_READ_CONTENT = 'file.read-content';
    public const ACTION_FILE_CREATE = 'file.create';
    public const ACTION_FILE_UPDATE = 'file.update';
    public const ACTION_FILE_DELETE = 'file.delete';
    public const ACTION_FILE_ARCHIVE = 'file.archive';
    public const ACTION_FILE_SFTP = 'file.sftp';

    public const ACTION_STARTUP_READ = 'startup.read';
    public const ACTION_STARTUP_UPDATE = 'startup.update';
    public const ACTION_STARTUP_DOCKER_IMAGE = 'startup.docker-image';

    public const ACTION_SETTINGS_RENAME = 'settings.rename';
    public const ACTION_SETTINGS_REINSTALL = 'settings.reinstall';

    public const ACTION_ACTIVITY_READ = 'activity.read';

    /**
     * Should timestamps be used on this model.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'permissions';

    /**
     * Fields that are not mass assignable.
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Cast values to correct type.
     */
    protected $casts = [
        'subuser_id' => 'integer',
    ];

    public static array $validationRules = [
        'subuser_id' => 'required|numeric|min:1',
        'permission' => 'required|string',
    ];

    /**
     * All the permissions available on the system. You should use self::permissions()
     * to retrieve them, and not directly access this array as it is subject to change.
     *
     * @see \Pterodactyl\Models\Permission::permissions()
     */
    protected static array $permissions = [
        'websocket' => [
            'description' => 'Permite que o usuário se conecte ao websocket do servidor, dando acesso à visualização do console e estatísticas em tempo real.',
            'keys' => [
                'connect' => 'Permite que o usuário se conecte ao websocket do servidor para visualizar o console.',
            ],
        ],

        'control' => [
            'description' => 'Permissões que controlam a capacidade do usuário de gerenciar o estado de energia do servidor ou enviar comandos.',
            'keys' => [
                'console' => 'Permite que o usuário envie comandos ao servidor através do console.',
                'start' => 'Permite que o usuário inicie o servidor caso ele esteja parado.',
                'stop' => 'Permite que o usuário desligue o servidor caso ele esteja em execução.',
                'restart' => 'Permite que o usuário reinicie o servidor. Isso permite iniciar o servidor caso esteja offline, mas não colocá-lo em estado totalmente parado.',
            ],
        ],

        'user' => [
            'description' => 'Permissões que permitem ao usuário gerenciar outros subusuários no servidor. Ele nunca poderá editar sua própria conta ou atribuir permissões que não possui.',
            'keys' => [
                'create' => 'Permite que o usuário crie novos subusuários para o servidor.',
                'read' => 'Permite que o usuário visualize os subusuários e suas permissões.',
                'update' => 'Permite que o usuário modifique outros subusuários.',
                'delete' => 'Permite que o usuário remova um subusuário do servidor.',
            ],
        ],

        'file' => [
            'description' => 'Permissões que controlam a capacidade do usuário de gerenciar o sistema de arquivos do servidor.',
            'keys' => [
                'create' => 'Permite que o usuário crie arquivos e pastas pelo painel ou upload direto.',
                'read' => 'Permite visualizar o conteúdo de diretórios, mas não visualizar ou baixar arquivos.',
                'read-content' => 'Permite visualizar o conteúdo de arquivos e baixá-los.',
                'update' => 'Permite editar o conteúdo de arquivos ou diretórios existentes.',
                'delete' => 'Permite excluir arquivos ou diretórios.',
                'archive' => 'Permite compactar diretórios e extrair arquivos compactados.',
                'sftp' => 'Permite conexão via SFTP para gerenciamento de arquivos.',
            ],
        ],

        'backup' => [
            'description' => 'Permissões que controlam a capacidade do usuário de criar e gerenciar backups do servidor.',
            'keys' => [
                'create' => 'Permite criar novos backups.',
                'read' => 'Permite visualizar os backups existentes.',
                'delete' => 'Permite remover backups do sistema.',
                'download' => 'Permite baixar backups do servidor. Atenção: isso concede acesso a todos os arquivos contidos no backup.',
                'restore' => 'Permite restaurar um backup. Atenção: isso apagará todos os arquivos atuais do servidor.',
            ],
        ],

        'allocation' => [
            'description' => 'Permissões que controlam a capacidade do usuário de gerenciar as alocações de portas do servidor.',
            'keys' => [
                'read' => 'Permite visualizar todas as alocações atribuídas ao servidor.',
                'create' => 'Permite adicionar novas alocações ao servidor.',
                'update' => 'Permite alterar a alocação principal e adicionar notas.',
                'delete' => 'Permite remover uma alocação do servidor.',
            ],
        ],

        'startup' => [
            'description' => 'Permissões que controlam o acesso do usuário às configurações de inicialização do servidor.',
            'keys' => [
                'read' => 'Permite visualizar as variáveis de inicialização.',
                'update' => 'Permite modificar as variáveis de inicialização.',
                'docker-image' => 'Permite alterar a imagem Docker utilizada pelo servidor.',
            ],
        ],

        'database' => [
            'description' => 'Permissões que controlam o acesso do usuário ao gerenciamento de bancos de dados do servidor.',
            'keys' => [
                'create' => 'Permite criar um novo banco de dados.',
                'read' => 'Permite visualizar o banco de dados do servidor.',
                'update' => 'Permite alterar a senha do banco de dados.',
                'delete' => 'Permite remover um banco de dados do servidor.',
                'view_password' => 'Permite visualizar a senha do banco de dados.',
            ],
        ],

        'schedule' => [
            'description' => 'Permissões que controlam o acesso do usuário ao gerenciamento de agendamentos do servidor.',
            'keys' => [
                'create' => 'Permite criar novos agendamentos.',
                'read' => 'Permite visualizar os agendamentos e tarefas.',
                'update' => 'Permite editar agendamentos e tarefas.',
                'delete' => 'Permite remover agendamentos.',
            ],
        ],

        'settings' => [
            'description' => 'Permissões que controlam o acesso do usuário às configurações do servidor.',
            'keys' => [
                'rename' => 'Permite renomear o servidor e alterar sua descrição.',
                'reinstall' => 'Permite reinstalar o servidor.',
            ],
        ],

        'activity' => [
            'description' => 'Permissões que controlam o acesso do usuário aos registros de atividade do servidor.',
            'keys' => [
                'read' => 'Permite visualizar os logs de atividade do servidor.',
            ],
        ],
    ];


    /**
     * Returns all the permissions available on the system for a user to
     * have when controlling a server.
     */
    public static function permissions(): Collection
    {
        return Collection::make(self::$permissions);
    }
}
