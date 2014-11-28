<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 23:26
 */

namespace XMLModel;
use XMLModel\Worksheet\WorksheetOptions;
use XMLModel\Worksheet\WorksheetOptions\PageSetup;
use XMLModel\Worksheet\WorksheetOptions\Header;
use XMLModel\Worksheet\WorksheetOptions\Footer;
use XMLModel\Worksheet\WorksheetOptions\HorizontalResolution;
use XMLModel\Worksheet\WorksheetOptions\Layout;
use XMLModel\Worksheet\WorksheetOptions\PageMargins;
use XMLModel\Worksheet\WorksheetOptions\PaperSizeIndex;
use XMLModel\Worksheet\WorksheetOptions\ValidPrinterInfo;
use XMLModel\Worksheet\WorksheetOptions\VerticalResolution;

use XMLModel\Worksheet\WorksheetOptions\XMLPrint;

class Worksheet extends \XMLModel\Base\XMLTeg {
    const Name = 'ss:Name';

   static function Option(){

    return  new WorksheetOptions( null, array(
           new PageSetup(null,array(
                   new Layout(array(Layout::Orientation=>'Landscape')),
                   new Header(array(Header::Margin=>'0.4')),
                   new Footer(array(Footer::Margin=>'0.4')),
                   new PageMargins(array(
                       PageMargins::Bottom=>'0.4',
                       PageMargins::Left=>'0.4',
                       PageMargins::Right=>'0.4',
                       PageMargins::Top=>'0.4'
                   ))
               )
           ),
           new XMLPrint(null, array(
               new ValidPrinterInfo(),
               new PaperSizeIndex(null, 9),
               new HorizontalResolution(null, 600),
               new VerticalResolution(null, 0)
           ))
       ));
   }
} 