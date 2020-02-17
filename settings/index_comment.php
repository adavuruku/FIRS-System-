
    <style>
        #quote-carousel {
            padding: 0 10px 30px 10px;
            margin-top: 5px;
			background: none;
            /* Control buttons  */
            /* Previous button  */
            /* Next button  */
            /* Changes the position of the indicators */
            /* Changes the color of the indicators */
        }
        
        #quote-carousel .carousel-control {
            background: none;
            color: #CACACA;
            font-size: 2.3em;
            text-shadow: none;
            margin-top: 30px;
        }
        
        #quote-carousel .carousel-control.left {
            left: -60px;
        }
        
        #quote-carousel .carousel-control.right {
            right: -60px;
        }
        
        #quote-carousel .carousel-indicators {
            right: 50%;
            top: auto;
            bottom: 0px;
            margin-right: -19px;
        }
        
        #quote-carousel .carousel-indicators li {
            width: 80px;
            height: 80px;
            margin: 5px;
            cursor: pointer;
            border: 4px solid #CCC;
            border-radius: 50px;
            opacity: 0.4;
            overflow: hidden;
            transition: all 0.5s;
        }
        
        #quote-carousel .carousel-indicators .active {
            background: blue;
            width: 150px;
            height: 150px;
            border-radius: 100px;
            border-color: #99CCFF;
            opacity: 1;
            overflow: hidden;
        }
        
        .carousel-inner {
            min-height: 300px;
        }
        
        .item blockquote {
            border-left: none;
            margin: 0;
			
        }
        
        /**.item blockquote p:before {
            content: "\f10d";
            font-family: 'Fontawesome';
            float: left;
            margin-right: 10px;
        }**/
    </style>
        <div class="featurette" id="about">
            <!------------------------code---------------start---------------->
            <div class="row">
                <div class="col-md-12" data-wow-delay="0.2s">
                    <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                        <!-- Bottom Carousel Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#quote-carousel" data-slide-to="0" class="active"><img class="img-responsive " src="resource/slides/car1.jpg" alt="">
                            </li>
                            <li data-target="#quote-carousel" data-slide-to="1"><img class="img-responsive" src="resource/slides/car2.jpg" alt="">
                            </li>
                            <li data-target="#quote-carousel" data-slide-to="2"><img class="img-responsive" src="resource/slides/car3.jpg" alt="">
                            </li>
							<li data-target="#quote-carousel" data-slide-to="3"><img class="img-responsive" src="resource/slides/car4.jpg" alt="">
                            </li>
							<li data-target="#quote-carousel" data-slide-to="4"><img class="img-responsive" src="resource/slides/car5.jpg" alt="">
                            </li>
                        </ol>

                        <!-- Carousel Slides / Quotes -->
                        <div class="carousel-inner text-center">

                            <!-- Quote 1 -->
                            <div class="item active">
                                <blockquote>
                                    <div class="row">
                                        <div  style="background-color:#99CCFF;padding:15px;font-family:tahoma;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);" class="col-sm-8 col-sm-offset-2">
                                            <p><i><span style="font-size:30px">&rdquo; </span>The system is the best i have seen so far. It has eliminated the stress of Calculating, Payment and Collection of Tax. I so much believe the current breakthrough of ICT in the FIRS will attract More Investors and thus more Job Opportunities for Our Nation.<span style="font-size:30px"> &ldquo;</span></i></p>
                                            <small>by <cite>Adavuruku Sherif A.</cite></small>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
                            <!-- Quote 2 -->
                            <div class="item">
                                <blockquote>
                                    <div class="row">
                                        <div style="background-color:#99CCFF;padding:15px;font-family:tahoma;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);" class="col-sm-8 col-sm-offset-2">

                                            <p><i><span style="font-size:30px">&rdquo; </span> This a welcome idea, one don't have to travel to FIRS Office just for calculation, collection and payment of Tax. Thanks to the Management Of FIRS for this initiative. <span style="font-size:30px"> &ldquo;</span></i></p>
                                            <small>by <cite>Nafisat Ele-Ojo.</cite></small>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
                            <!-- Quote 3 -->
                            <div class="item">
                                <blockquote>
                                    <div class="row">
                                        <div style="background-color:#99CCFF;padding:15px;font-family:tahoma;border;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);" class="col-sm-8 col-sm-offset-2">

                                            <p><i><span style="font-size:30px">&rdquo; </span> The Management of FIRS has shown their concern to the welfare of Business Owners Operating In Nigeria with this development. This will inturn play a tremendous role in easing the business Environment in the Country. I hope to see more ICT initiative from the management soon. <span style="font-size:30px"> &ldquo;</span></i></p>
                                            <small>by <cite>Eneye Danjuma.</cite></small>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
							<!-- Quote 4 -->
                            <div class="item">
                                <blockquote>
                                    <div class="row">
                                        <div style="background-color:#99CCFF;padding:15px;font-family:tahoma;border;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);" class="col-sm-8 col-sm-offset-2">

                                            <p><i><span style="font-size:30px">&rdquo; </span>The most threat of every Company Operating in Nigeria is the stress they face in the process of calculating, payment and collection of tax receipt but with this new initiative easy access through this initiave to carry any tax relating to tax Management. I hope to see more IT initiative from the Management. <span style="font-size:30px"> &ldquo;</span></i></p>
                                            <small>by <cite>Jude Okonkwo.</cite></small>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
							<!-- Quote 5 -->
                            <div class="item">
                                <blockquote>
                                    <div class="row">
                                        <div style="background-color:#99CCFF;padding:15px;font-family:tahoma;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);" class="col-sm-8 col-sm-offset-2">

                                            <p><i><span style="font-size:30px">&rdquo; </span> The management FIRS under the coordination of the New Administration has shown there tremendous support to the Business Community with the implementation of IT Project in several aspect of the daily activities of the Institution. But this one is the best of all their other numerous initiatives.  <span style="font-size:30px"> &ldquo;</span></i></p>
                                            <small>by <cite>Atabor Eugene.</cite></small>
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Carousel Buttons Next/Prev -->
						
                        <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="glyphicon glyphicon-chevron-left"></i></a>
                        <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i  class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <!----Code------end----------------------------------->
        </div>
