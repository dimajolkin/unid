<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 18.08.14
 * Time: 1:53
 */

namespace XMLModel;

use XMLModel\Styles\Borders;
use XMLModel\Styles\Border;
use XMLModel\Styles\Style;
use XMLModel\Styles\Alignment;
use XMLModel\Styles\Font;
use XMLModel\Styles\Interior;
use XMLModel\Styles\NumberFormat;
use XMLModel\Styles\Protection;




class Styles extends \XMLModel\Base\XMLTeg {



    static function DefaultStyle(){
        return array(
            new Style(
                array(
                    Style::ID=>'Default',
                    Style::NAME =>'Normal'
                ),
                array(
                    new Alignment(array( Alignment::Vertical=>'Bottom' )),
                    new Borders(),
                    new Font(Font::getDafaultValue() ),
                    new Interior(),
                    new NumberFormat(),
                    new Protection()
                )
            ),
            new Style( array(Style::ID => 's71'),array( new Font(Font::getDafaultValue()))),
            new Style(array(Style::ID=>'s73'),array(
                new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Center',Alignment::WrapText=>1)),
                new Borders(null, array(
                    new Border(array(Border::Position=>'Bottom',Border::LineStyle=>'Continuous',Border::Weight=>2)),
                    new Border(array(Border::Position=>'Left',Border::LineStyle=>'Continuous',Border::Weight=>2)),
                    new Border(array(Border::Position=>'Right',Border::LineStyle=>'Continuous',Border::Weight=>2)),
                    new Border(array(Border::Position=>'Top',Border::LineStyle=>'Continuous',Border::Weight=>2)),
                )),
                new Font(array(Font::FontName=>'Arial',Font::CharSet=>204,Font::Family=>'Swiss',Font::Size=>8,Font::Color=>'#000000',Font::Bold=>1))
            )),
            new Style(array(Style::ID=>'s75'),array(
                    new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Bottom')),
                    new Font( Font::getDafaultValue())
                )
            ),
            new Style(array(Style::ID=>'s77'),array(
                new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Bottom')),
                new Borders(null,
                    new Border(array(Border::Position=>'Top',Border::LineStyle=>'Continuous',Border::Weight=>1))
                ),
                new Font(Font::getDafaultValue())
            )),
            new Style(array(Style::ID=>'s80'),array(
                new Alignment(array(Alignment::Horizontal=>'Center',Alignment::WrapText=>1)),
                new Borders(null, array(
                    new Border(array(Border::Position=>'Bottom',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Left',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Right',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Top',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                )),
                new Font(array(Font::FontName=>'Arial',Font::CharSet=>204,Font::Family=>'Swiss',Font::Size=>8,Font::Color=>'#000000'))
            )),
            new Style(array(Style::ID=>'s81'),array(
                new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Center',Alignment::WrapText=>1)),
                new Borders(null, array(
                    new Border(array(Border::Position=>'Bottom',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Left',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Right',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                    new Border(array(Border::Position=>'Top',Border::LineStyle=>'Continuous',Border::Weight=>1)),
                )),
                new Font(array(Font::FontName=>'Arial',Font::CharSet=>204,Font::Family=>'Swiss',Font::Size=>8,Font::Color=>'#000000',Font::Bold=>1))
            )),
            new Style(array(Style::ID=>'s82'),array(
                    new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Bottom')),
                    new Font( Font::getDafaultValue())
                )
            ),
            new Style(array(Style::ID=>'s83'),array(
                    new Alignment(array(Alignment::Horizontal=>'Center',Alignment::Vertical=>'Bottom')),
                    new Font( Font::getDafaultValue())
                )
            )

        );
    }
} 