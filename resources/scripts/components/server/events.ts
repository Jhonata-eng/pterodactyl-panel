export enum SocketEvent {
    DAEMON_MESSAGE = 'mensagem do daemon',
    DAEMON_ERROR = 'erro do daemon',
    INSTALL_OUTPUT = 'saída da instalação',
    INSTALL_STARTED = 'instalação iniciada',
    INSTALL_COMPLETED = 'instalação concluída',
    CONSOLE_OUTPUT = 'saída do console',
    STATUS = 'status',
    STATS = 'estatísticas',
    TRANSFER_LOGS = 'logs de transferência',
    TRANSFER_STATUS = 'status da transferência',
    BACKUP_COMPLETED = 'backup concluído',
    BACKUP_RESTORE_COMPLETED = 'restauração de backup concluída',
}

export enum SocketRequest {
    SEND_LOGS = 'enviar logs',
    SEND_STATS = 'enviar estatísticas',
    SET_STATE = 'definir estado',
}
