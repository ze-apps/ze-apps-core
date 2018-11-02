<?php

namespace Zeapps\Core;

use Zeapps\Core\ModelExportType ;

interface iModelExport {

    /**
     * GetCron that the observerReceive
     *
     * @return array
     */
    public function getModelExport() : ModelExportType;

}