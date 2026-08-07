<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        @if (myalerts()->count()>0)
                              <span class="notification">{{myalerts()->count()}}</span>
                        @endif

                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">You have  {{myalerts()->count()}} new notification</div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer" style="height: 400px !important" >
                                <div style="background:white">
                                    <div style="height: 300px;overflow:auto;" >
                                        <div class="notif-center" >
                                    @foreach(myalerts() as $a)
                                    <a href="#" onclick="alerts_set_as_ready(this)" data-alert-id="{{$a->id}}" data-web-url="{{$a->web_url}}" >
                                        <div class="notif-icon "> <i class="fa fa-bell"></i> </div>
                                        <div class="notif-content">
													<span class="block">
                                                        <label>{{substr($a->title,0,25)}}</label><br>
														{{substr($a->message,0,30)}}...
													</span>
                                            <span class="time">{{$a->created_at->diffForHumans()}}</span>
                                        </div>
                                    </a>


                                    @endforeach
                                </div>
                                    </div>
                                                                 <h4  onclick="alert_read_all(this)" style="padding: 5px;text-align:right;cursor:pointer">Read all</h4>

                                </div>

                            </div>
                        </li>


                    </ul>
