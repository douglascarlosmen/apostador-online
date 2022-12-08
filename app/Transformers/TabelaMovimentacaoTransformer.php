<?php

namespace App\Transformers;

class TabelaMovimentacaoTransformer
{

    protected $results;
    protected $dozens;

    public function __construct($results, array $dozens)
    {
        $this->results = $results;
        $this->dozens = $dozens;
    }

    public function transform()
    {
        $contestsDozens = [];
        $dozensControl = [];
        $contestQuantity = count($this->results);

        foreach ($this->results as $result) {
            $resultDozens = json_decode($result->dozens, true);
            $contestsDozens[$result->contest_number]['dozens'] = $resultDozens;
            if (!is_null($result->cycle)) {
                $contestsDozens[$result->contest_number]['cycle'] = $result->cycle;
            }

            foreach ($this->dozens as $dozen) {
                if (in_array($dozen, $resultDozens)) {

                    if ($dozen % 2 == 0) {
                        if(!isset($contestsDozens[$result->contest_number]['even'])) {
                            $contestsDozens[$result->contest_number]['even'] = 1;
                        } else {
                            $contestsDozens[$result->contest_number]['even'] += 1;
                        }
                    } else {
                        if(!isset($contestsDozens[$result->contest_number]['odd'])) {
                            $contestsDozens[$result->contest_number]['odd'] = 1;
                        } else {
                            $contestsDozens[$result->contest_number]['odd'] += 1;
                        }
                    }


                    /**
                     * Calculando a Frequência em Quantidade
                     */
                    if (isset($dozensControl[$dozen]['freq_qtd'])) {
                        $dozensControl[$dozen]['freq_qtd'] += 1;
                    } else {
                        $dozensControl[$dozen]['freq_qtd'] = 1;
                    }

                    /**
                     * Calculando Maior Atraso
                     */
                    if (!isset($dozensControl[$dozen]['maior_atraso_atual']) && isset($dozensControl[$dozen]['maior_atraso'])) {
                        $dozensControl[$dozen]['maior_atraso_atual'] = $dozensControl[$dozen]['maior_atraso'];
                    } else if (isset($dozensControl[$dozen]['maior_atraso_atual']) && $dozensControl[$dozen]['maior_atraso'] > $dozensControl[$dozen]['maior_atraso_atual']) {
                        $dozensControl[$dozen]['maior_atraso_atual'] = $dozensControl[$dozen]['maior_atraso'];
                    }

                    /**
                     * Último Concurso em que a Dezena apareceu
                     */
                    $dozensControl[$dozen]['last_contest'] = $result->contest_number;

                    /**
                     * Calculando Maior Sequência
                     */
                    if (!isset($dozensControl[$dozen]['maior_seq'])) {
                        $dozensControl[$dozen]['maior_seq'] = 1;
                    } else {
                        $dozensControl[$dozen]['maior_seq'] += 1;
                    }
                } else {

                    /**
                     * Calculando Maior Atraso
                     */
                    if (!isset($dozensControl[$dozen]['maior_atraso'])) {
                        $dozensControl[$dozen]['maior_atraso'] = 1;
                    } else {
                        $dozensControl[$dozen]['maior_atraso'] += 1;
                    }

                    /**
                     * Calculando Maior Sequência
                     */
                    if (!isset($dozensControl[$dozen]['maior_seq_atual']) && isset($dozensControl[$dozen]['maior_seq'])) {
                        $dozensControl[$dozen]['maior_seq_atual'] = $dozensControl[$dozen]['maior_seq'];
                        $dozensControl[$dozen]['maior_seq'] = 0;
                    } else if (isset($dozensControl[$dozen]['maior_seq_atual']) && $dozensControl[$dozen]['maior_seq'] > $dozensControl[$dozen]['maior_seq_atual']) {
                        $dozensControl[$dozen]['maior_seq_atual'] = $dozensControl[$dozen]['maior_seq'];
                        $dozensControl[$dozen]['maior_seq'] = 0;
                    }
                }
            }
        }

        foreach ($dozensControl as $index => $dozenControl) {
            /**
             * Calculando a Frequência em Porcentagem
             */
            $dozensControl[$index]['freq_porc'] = isset($dozenControl['freq_qtd']) ? number_format(($dozenControl['freq_qtd'] / $contestQuantity) * 100, 0) : 0;

            /**
             * Calculando atraso atual
             */
            $dozensControl[$index]['atraso_atual'] = isset($dozenControl['last_contest']) ? count($this->results->where('contest_number', '>', $dozenControl['last_contest'])) : '';

            /**
             * Calculando Maior Atraso
             */
            if ((isset($dozensControl[$dozen]['maior_atraso']) && isset($dozensControl[$dozen]['maior_atraso_atual'])) && $dozensControl[$dozen]['maior_atraso'] < $dozensControl[$dozen]['maior_atraso_atual']) {
                $dozensControl[$dozen]['maior_atraso'] = $dozensControl[$dozen]['maior_atraso_atual'];
            }
        }

        ksort($dozensControl);

        return [$dozensControl, $contestsDozens];
    }
}
