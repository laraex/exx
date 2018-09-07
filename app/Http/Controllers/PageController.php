<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Page;
use App\Models\Faq;
use App\Models\News;
//use Illuminate\Database\Eloquent\Collection;

class PageController extends Controller
{

    /**
     * Get About Page
     *
     * @return void
     * FIXME:
     */
    public function about()
    {
         $pages  = Page::get();

        return view('pages.about', [
                'pages' => $pages
            ]);
    }

    /**
     * Show a single page based on slug
     *
     * @param [type] $slug
     * @return void
     */
    public function show($slug)
    {
          if(!is_null(\Session::get('locale')))
       {
           $lang = \Session::get('locale');
       }
       else
       {
           $lang = "en";
       }
       //echo $lang;
        $pages  = Page::get();
        $pagedetails  = $pages->where('language', '=', $lang)->where('slug', '=', $slug)->first();

        //dd($pagedetails);

        return view('pages.custompages', [
                'pages' => $pages,
                'pagedetails' => $pagedetails,
                'slug' => $slug
            ]);
    }

    /** 
     * Load FAQ Page
     */
    public function faq()
    {

        if(!is_null(\Session::get('locale')))
       {
           $lang = \Session::get('locale');
       }
       else
       {
           $lang = "en";
       }



        $faq  = Faq::where([['active','1'],['language', $lang]])->orderBy('order', 'ASC')->paginate(10);
        return view('pages.faq', [
                'faq' => $faq,
            ]);
    }

    /**
     * Load Privacy Page
     *
     * @return void
     */
    public function privacy()
    {

         $pages  = Page::get();

        return view('pages.privacy', [
                'pages' => $pages
            ]);
    }

    public function market()
    {
        return view('marketdata');
    }

    public function chart()
    {
        return view('chart');
    }

    /**
     * Load Terms page
     *
     * @return void
     */
    public function terms()
    {

        $pages  = Page::get();

        return view('pages.terms', [
                'pages' => $pages
            ]);
    }

    /**
     * Load News
     *
     * @return void
     */
    public function news()
    {

        $news  = News::where('active', '=', '1')->latest('updated_at')->paginate(\Config::get('settings.pagecount'));

        return view('pages.news', [
                'news' => $news,
            ]);
    }

    public function newsDetails($id)
    {
         //dd($id);
        $news  = News::where('active', '=', '1')->where('id',$id)->first();



        return view('pages.latestnews', [
                'news' => $news,
            ]);
    }
    public function Latestnews()
    {
        if(!is_null(\Session::get('locale')))
       {
           $lang = \Session::get('locale');
       }
       else
       {
           $lang = "en";
       }
      $news  = News::where([['active', 1],['language', $lang]])->latest('updated_at')->take(3)->get();
         $members =new Collection;
             foreach($news  as $new){
               $newtime=explode(' ',$new->updated_at);
                $newdates=explode('-',$newtime[0]);
             $month_date=$newdates[1]."-".$newdates[2];
               $latest_news=array('title'=>$new->title,'updated_at'=>$month_date,'id'=>$new->id);
               $members->push($latest_news);
             }
           
             //dd($members);
        return $members;
    }

    public function page() 
    {
        $pages = Page::get();      
        return view('pages.page',[
            'pages' => $pages,
        ]);
    }
}
