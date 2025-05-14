<?php
class Processo {
    private $parcial = 0;
    private $prorroga = 0;
    private $renova = 0;
    private $final = 0;
    private $estado = 'inicial'; // Estados possíveis: 'inicial', 'pos_prorroga', 'finalizado'
    
    // Retorna as opções disponíveis no estado atual
    public function getOpcoesDisponiveis() {
        switch ($this->estado) {
            case 'inicial':
                return ['parcial', 'prorroga', 'renova', 'final'];
            case 'pos_prorroga':
                return ['parcial', 'renova', 'final'];
            case 'finalizado':
                return [];
            default:
                return [];
        }
    }
    
    // Processa a seleção de uma opção
    public function selecionarOpcao($opcao) {
        if (!in_array($opcao, $this->getOpcoesDisponiveis())) {
            return false; // Opção inválida para o estado atual
        }
        
        switch ($opcao) {
            case 'parcial':
                $this->parcial++;
                // Permanece no mesmo estado
                break;
            case 'prorroga':
                $this->prorroga++;
                $this->estado = 'pos_prorroga';
                break;
            case 'renova':
                $this->renova++;
                $this->estado = 'finalizado';
                break;
            case 'final':
                $this->final++;
                $this->estado = 'finalizado';
                break;
        }
        
        return true;
    }
    
    // Getters para os valores
    public function getParcial() { return $this->parcial; }
    public function getProrroga() { return $this->prorroga; }
    public function getRenova() { return $this->renova; }
    public function getFinal() { return $this->final; }
    public function getEstado() { return $this->estado; }
}

// Exemplo de uso:
$processo = new Processo();

// Estado inicial
echo 'inicio:<br>';
echo implode(', ', $processo->getOpcoesDisponiveis()) . "<br>";
echo '<hr>';
$a = 0;
// Seleciona 'parcial'
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 

$processo->selecionarOpcao('prorroga'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('parcial'); echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 
$processo->selecionarOpcao('renova');  echo 'int ' . $a++ .' '.implode(', ', $processo->getOpcoesDisponiveis()) . "<br>"; 

implode(', ', $processo->getOpcoesDisponiveis()) . "<br>";

echo 'fim:<br>';




/*
// Seleciona 'prorroga'
$processo->selecionarOpcao('prorroga');
echo "Prorroga: " . $processo->getProrroga() . "<br>";
echo implode(', ', $processo->getOpcoesDisponiveis()) . "<br>";

// Seleciona 'final'
$processo->selecionarOpcao('final');
echo "Final: " . $processo->getFinal() . "<br>";
echo implode(', ', $processo->getOpcoesDisponiveis()) . "<br>";
?>