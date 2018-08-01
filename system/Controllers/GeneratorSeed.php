<?php

namespace Zeapps\Controllers;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use Zeapps\Core\Session;

use App\com_zeapps_contact\Models\AccountingNumbers;

use App\com_zeapps_crm\Models\ProductCategories;
use App\com_zeapps_crm\Models\ProductProducts;
use App\com_zeapps_crm\Models\ProductLines;
use App\com_zeapps_crm\Models\ProductStocks;

use App\com_zeapps_crm\Models\Quotes;
use App\com_zeapps_crm\Models\QuoteLines;
use App\com_zeapps_crm\Models\QuoteLineDetails;
use App\com_zeapps_crm\Models\QuoteActivities;

use App\com_zeapps_crm\Models\Orders;
use App\com_zeapps_crm\Models\OrderLines;
use App\com_zeapps_crm\Models\OrderLineDetails;
use App\com_zeapps_crm\Models\OrderActivities;

use App\com_zeapps_crm\Models\Invoices;
use App\com_zeapps_crm\Models\InvoiceLines;
use App\com_zeapps_crm\Models\InvoiceLineDetails;
use App\com_zeapps_crm\Models\InvoiceActivities;

use App\com_zeapps_crm\Models\Deliveries;
use App\com_zeapps_crm\Models\DeliveryLines;
use App\com_zeapps_crm\Models\DeliveryLineDetails;
use App\com_zeapps_crm\Models\DeliveryActivities;

use Illuminate\Database\Capsule\Manager as Capsule;


use App\fr_abeko_plan\Models\Articles;
use App\fr_abeko_plan\Models\ArticlesComposes;
use App\fr_abeko_plan\Models\ArticlesComposesLignes;
use App\fr_abeko_plan\Models\Baches;
use App\fr_abeko_plan\Models\CiternesTypes;
use App\fr_abeko_plan\Models\CiternesTypesArticles;
use App\fr_abeko_plan\Models\CiterneTarifs;
use App\fr_abeko_plan\Models\CiterneTarifsLignes;
use App\fr_abeko_plan\Models\Conditionnements;
use App\fr_abeko_plan\Models\Logos;
use App\fr_abeko_plan\Models\PlanArticles;
use App\fr_abeko_plan\Models\PlanArticlesComposes;
use App\fr_abeko_plan\Models\PlanArticlesComposesLignes;
use App\fr_abeko_plan\Models\PlanPositions;
use App\fr_abeko_plan\Models\PlanProduits;
use App\fr_abeko_plan\Models\Plans;


class GeneratorSeed extends Controller
{
    public function generate()
    {

        /*$this->save("fr_abeko_plan", "Articles.json", json_encode(Articles::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "ArticlesComposes.json", json_encode(ArticlesComposes::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "ArticlesComposesLignes.json", json_encode(ArticlesComposesLignes::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "Baches.json", json_encode(Baches::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "CiternesTypes.json", json_encode(CiternesTypes::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "CiternesTypesArticles.json", json_encode(CiternesTypesArticles::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "CiterneTarifs.json", json_encode(CiterneTarifs::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "CiterneTarifsLignes.json", json_encode(CiterneTarifsLignes::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "Conditionnements.json", json_encode(Conditionnements::get(), JSON_PRETTY_PRINT));
        $this->save("fr_abeko_plan", "Logos.json", json_encode(Logos::get(), JSON_PRETTY_PRINT));*/
        //$this->save("fr_abeko_plan", "PlanArticles.json", json_encode(PlanArticles::get(), JSON_PRETTY_PRINT));
        //$this->save("fr_abeko_plan", "PlanArticlesComposes.json", json_encode(PlanArticlesComposes::get(), JSON_PRETTY_PRINT));
        //$this->save("fr_abeko_plan", "PlanArticlesComposesLignes.json", json_encode(PlanArticlesComposesLignes::get(), JSON_PRETTY_PRINT));
        //$this->save("fr_abeko_plan", "PlanPositions.json", json_encode(PlanPositions::get(), JSON_PRETTY_PRINT));
        //$this->save("fr_abeko_plan", "PlanProduits.json", json_encode(PlanProduits::get(), JSON_PRETTY_PRINT));
        //$this->save("fr_abeko_plan", "Plans.json", json_encode(Plans::get(), JSON_PRETTY_PRINT));



        /*
        // AccountingNumbers
        $this->save("com_zeapps_contact", "AccountingNumbers.json", json_encode(AccountingNumbers::get(), JSON_PRETTY_PRINT));



        // ProductCategories
        $this->save("com_zeapps_crm", "ProductCategories.json", json_encode(ProductCategories::get(), JSON_PRETTY_PRINT));

        // ProductProducts
        $this->save("com_zeapps_crm", "ProductProducts.json", json_encode(ProductProducts::get(), JSON_PRETTY_PRINT));

        // ProductLines
        $this->save("com_zeapps_crm", "ProductLines.json", json_encode(ProductLines::get(), JSON_PRETTY_PRINT));

        // ProductStocks
        $this->save("com_zeapps_crm", "ProductStocks.json", json_encode(ProductStocks::get(), JSON_PRETTY_PRINT));



        // Quotes
        $this->save("com_zeapps_crm", "Quotes.json", json_encode(Quotes::get(), JSON_PRETTY_PRINT));

        // QuoteLines
        $this->save("com_zeapps_crm", "QuoteLines.json", json_encode(QuoteLines::get(), JSON_PRETTY_PRINT));

        // QuoteLineDetails
        $this->save("com_zeapps_crm", "QuoteLineDetails.json", json_encode(QuoteLineDetails::get(), JSON_PRETTY_PRINT));

        // QuoteActivities
        $this->save("com_zeapps_crm", "QuoteActivities.json", json_encode(QuoteActivities::get(), JSON_PRETTY_PRINT));




        // Orders
        $this->save("com_zeapps_crm", "Orders.json", json_encode(Orders::get(), JSON_PRETTY_PRINT));

        // OrderLines
        $this->save("com_zeapps_crm", "OrderLines.json", json_encode(OrderLines::get(), JSON_PRETTY_PRINT));

        // OrderLineDetails
        $this->save("com_zeapps_crm", "OrderLineDetails.json", json_encode(OrderLineDetails::get(), JSON_PRETTY_PRINT));

        // OrderActivities
        $this->save("com_zeapps_crm", "OrderActivities.json", json_encode(OrderActivities::get(), JSON_PRETTY_PRINT));




        // Invoices
        $this->save("com_zeapps_crm", "Invoices.json", json_encode(Invoices::get(), JSON_PRETTY_PRINT));

        // InvoiceLines
        $this->save("com_zeapps_crm", "InvoiceLines.json", json_encode(InvoiceLines::get(), JSON_PRETTY_PRINT));

        // InvoiceLineDetails
        $this->save("com_zeapps_crm", "InvoiceLineDetails.json", json_encode(InvoiceLineDetails::get(), JSON_PRETTY_PRINT));

        // InvoiceActivities
        $this->save("com_zeapps_crm", "InvoiceActivities.json", json_encode(InvoiceActivities::get(), JSON_PRETTY_PRINT));





        // Deliveries
        $this->save("com_zeapps_crm", "Deliveries.json", json_encode(Deliveries::get(), JSON_PRETTY_PRINT));

        // DeliveryLines
        $this->save("com_zeapps_crm", "DeliveryLines.json", json_encode(DeliveryLines::get(), JSON_PRETTY_PRINT));

        // DeliveryLineDetails
        $this->save("com_zeapps_crm", "DeliveryLineDetails.json", json_encode(DeliveryLineDetails::get(), JSON_PRETTY_PRINT));

        // DeliveryActivities
        $this->save("com_zeapps_crm", "DeliveryActivities.json", json_encode(DeliveryActivities::get(), JSON_PRETTY_PRINT));
        */

    }

    private function save($module, $seedname, $content)
    {

        $file = MODULEPATH . $module . "/Database/Seed/" . $seedname;

        if (file_exists($file)) {
            unlink($file);
        }
        $handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        fwrite($handle, $content);
        fclose($handle);
    }
}