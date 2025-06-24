<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Http\Filters\V1\TicketFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Policies\V1\TicketPolicy;


class AuthorTicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;
    public function index($author_id, TicketFilter $filters){
        return TicketResource::collection(
            Ticket::where('user_id',$author_id)
            ->filter($filters)
            ->paginate());
    }

    public function store($author_id, StoreTicketRequest $request)
    {
        try{
            $this->isAble('store', Ticket::class);

            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author'=> 'user_id'
            ])));
        }

        catch(AuthorizationException $ex){
            return $this->error('You are not authorized for this content',403);
        }
    }

    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id){
        //Put
        try{
            $ticket = Ticket::where('id', $ticket_id)
            ->where('user_id',$author_id)
            ->firstOrFail();

            $this->isAble('replace', $ticket);

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

            //if fail add later
        }

        catch(ModelNotFoundException $exception){
            return $this->error('Ticket not found',404);
        } catch(AuthorizationException $ex){
            return $this->error('You are not authorized for this content',403);
        }
    }

     public function update(UpdateTicketRequest $request, $author_id, $ticket_id){
        //Put
        try{
            $ticket = Ticket::where('id', $ticket_id)
            ->where('user_id',$author_id)
            ->firstOrFail();

            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

            //if fail add later
        }

        catch(ModelNotFoundException $exception){
            return $this->error('Ticket not found',404);
        } catch(AuthorizationException $ex){
            return $this->error('You are not authorized for this content',403);
        }
    }

    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::where('id', $ticket_id)
            ->where('user_id',$author_id)
            ->firstOrFail();

            $this->isAble('delete', $ticket);

            $ticket->delete();

            return $this->ok('Ticket successfully deleted');

        } catch(ModelNotFoundException $exception) {
            return $this->error('Ticket not found',404);
        } catch(AuthorizationException $ex){
            return $this->error('You are not authorized for this content',403);
        }
    }
}
