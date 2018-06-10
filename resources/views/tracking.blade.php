@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tracking</div>
                <div class="panel-body" id="panel-body-news">
                    (<strong>Note:</strong>) Date range is not supported on IE<=11

                    <br  /><br  />

                    <form action="/tracking">
                        Set your own date range for tracking page visits
                        <br />
                        <ul class="list-group">
                            <li class="list-group-item">Data Range</li>
                            <li class="list-group-item">
                              <input type="date" name="start_date"
                                value="{{$start_date}}">
                              &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                              <input type="date" name="end_date"
                                value="{{$end_date}}">
                            </li>
                        </ul>

                        <input type="submit" value="Submit">
                    </form>

                    <br /><br />
                    <h2>Summary Data</h2>
                    <br />

                    <ul class="list-group">
                      <li class="list-group-item">
                        On initial page load -
                        Default Summary (total number of page views
                        and unique number of page views from the past 7 days
                        <br /><br />
                        If range is set - summary across range
                        <br /><br />
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">
                            Total number of page views : <strong>{{$total_views}}</strong>
                          </li>
                          <li class="list-group-item">
                            Unique number of page views : <strong>{{$unique_views}}</strong>
                            <br />
                            <strong>(NOTE) :</strong> This is the sum of unique page visits for each session id.
                          </li>
                        </ul>
                      </li>
                    </ul>
                </div>
                <div style="text-align:center">
                    <a href="tracking/csvSummary">Download CSV Summary</a>
                </div>
                <br  /><br  />
            </div>
        </div>
    </div>
</div>
@endsection
