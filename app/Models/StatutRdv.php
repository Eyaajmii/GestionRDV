<?php

namespace App\Models;

enum StatutRdv: string
{
    case Planifie = 'planifie';
    case Confirme = 'confirme';
    case Annule   = 'annule';
    case Termine  = 'termine';
}