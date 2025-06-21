<?php
class NotaFiscal {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Emite nota com itens (array)
    public function emitir($id_cli_fk, $itens) {
        $total_nfe = 0;
        foreach ($itens as $item) {
            $total_nfe += $item['quantidade'] * $item['preco_unitario'];
        }

        $numero_nfe = date('YmdHis'); // Número único, timestamp
        $serie_nfe = '1';
        $dataEmissao = date('Y-m-d H:i:s');

        // Monta o XML
        $xmlItens = '';
        foreach ($itens as $item) {
            $xmlItens .= "
                <item>
                    <id_prod_fk>{$item['produto_id']}</id_prod_fk>
                    <qtd_iten>{$item['quantidade']}</qtd_iten>
                    <preco_unitario_iten>{$item['preco_unitario']}</preco_unitario_iten>
                </item>";
        }

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <notaFiscal>
            <id_cli_fk>{$id_cli_fk}</id_cli_fk>
            <total_nfe>{$total_nfe}</total_nfe>
            <itens>{$xmlItens}
            </itens>
            <data>{$dataEmissao}</data>
        </notaFiscal>";

        try {
            $this->pdo->beginTransaction();

            // Insere nota fiscal com XML
            $sql = "INSERT INTO notas_fiscais 
                    (id_cli_fk, numero_nfe, serie_nfe, data_emissao_nfe, total_nfe, xml) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_cli_fk, $numero_nfe, $serie_nfe, $dataEmissao, $total_nfe, $xml]);
            $id_nfe = $this->pdo->lastInsertId();

            // Insere itens da nota
            $sqlItem = "INSERT INTO itens_nota 
                        (id_nfe_fk, id_prod_fk, qtd_iten, preco_unitario_iten, subtotal_iten)
                        VALUES (?, ?, ?, ?, ?)";
            $stmtItem = $this->pdo->prepare($sqlItem);

            foreach ($itens as $item) {
                $subtotal = $item['quantidade'] * $item['preco_unitario'];
                $stmtItem->execute([
                    $id_nfe,
                    $item['produto_id'],
                    $item['quantidade'],
                    $item['preco_unitario'],
                    $subtotal
                ]);
            }

            $this->pdo->commit();

            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }


    public function listar() {
        $sql = "SELECT nf.*, c.nome_cli AS cliente_nome 
                FROM notas_fiscais nf
                JOIN clientes c ON nf.id_cli_fk = c.id_cli
                ORDER BY nf.data_emissao_nfe DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarItens($id_nfe) {
        $sql = "SELECT i.*, p.nome_prod AS produto_nome 
                FROM itens_nota i
                JOIN produtos p ON i.id_prod_fk = p.id_prod
                WHERE i.id_nfe_fk = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_nfe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
