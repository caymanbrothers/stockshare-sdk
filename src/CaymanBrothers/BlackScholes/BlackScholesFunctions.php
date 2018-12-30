<?

namespace CaymanBrothers\BlackScholes;

class BlackScholesFunctions
{

    public function N($x) {
        {
            $b1 =  0.319381530;
            $b2 = -0.356563782;
            $b3 =  1.781477937;
            $b4 = -1.821255978;
            $b5 =  1.330274429;
            $p  =  0.2316419;
            $c  =  0.39894228;
            
            if($x >= 0.0) {
                $t = 1.0 / ( 1.0 + $p * $x );
                return (1.0 - $c * exp( -$x * $x / 2.0 ) * $t *
                ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
            } else {
                $t = 1.0 / ( 1.0 - $p * $x );
                return ( $c * exp( -$x * $x / 2.0 ) * $t *
                ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
            }
        }
    }

    public function d1($S, $X, $t, $r, $q, $o)
    {
        $counter = log($S/$X)+$t*($r-$q+(pow($o, 2)/2));
        $denominator = $o*sqrt($t);
        $d1 = $counter/$denominator;
        
        return $d1;
    }

    public function d2($d1, $o, $t)
    {
        $d2 = $d1-$o*sqrt($t);
    
        return $d2;
    }

    public function call($S, $q, $t, $d1, $X, $r, $d2) {
    
        $call = $S*exp(-$q*$t)*$this->N($d1)-$X*exp(-$r*$t)*$this->N($d2);
        
        return $call;
        
    }

    public function put($S, $q, $t, $d1, $X, $r, $d2) {
    
        $put = $X*exp(-$r*$t)*$this->N(-$d2)-$S*exp(-$q*$t)*$this->N(-$d1);
        
        return $put;
        
    }

}
