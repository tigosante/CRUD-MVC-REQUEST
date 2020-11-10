<?php

namespace  core\classes\interfaces\Audit;

use core\classes\interfaces\Helpers\SetDataHelper;

interface AuditInterface extends SetDataHelper
{
    /**
     * @return self
     */
    public function config(AuditObjectInterface &$objectAudit);

    /**
     * @return string
     */
    public function getQueryAudit();

    /**
     * @return bool
     */
    public function isMakeAudit();

    /**
     * @return void
     */
    public function notify(bool $isMakeAudit);

    /**
     * @return bool
     */
    public function createAuditInDB(\PDO &$connection);

    /**
     * @return string
     */
    public function recuperar_ip_maquina_usuario();
}
