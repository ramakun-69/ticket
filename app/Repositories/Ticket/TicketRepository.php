<?php

namespace App\Repositories\Ticket;

use LaravelEasyRepository\Repository;

interface TicketRepository extends Repository{

   public function storeStaff($data);
   public function storeNonStaff($data);
   public function confirmByBoss($data);
   public function tehcnicianProcess($data);
   public function confirmByTechnicianBoss($data);
   public function confirmByTechnician($request);
   public function closeTicket($request);

}