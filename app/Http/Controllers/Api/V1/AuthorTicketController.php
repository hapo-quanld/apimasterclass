<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Http\Filters\V1\TicketFilter;

class AuthorTicketController extends Controller
{
    public function index($author_id, TicketFilter $filters){
        return TicketResource::collection(
            Ticket::where('user_id',$author_id)
            ->filter($filters)
            ->paginate());
    }
}
