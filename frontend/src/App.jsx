import React, { useState, useEffect } from 'react';
import './App.css';

export default function App() {
  const [formData, setFormData] = useState({
    clienteCod: '',
    peso: '',
    tipoCliente: 'NUEVO',
    tipoEnvio: 'ESTANDAR'
  });

  const [parametros, setParametros] = useState(null);
  const [resultado, setResultado] = useState(null);
  const [showModalResult, setShowModalResult] = useState(false);
  const [showModalError, setShowModalError] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const obtenerParametros = async () => {
      try {
        const res = await fetch('http://localhost:8000/api/parametros');
        if (res.ok) {
          const data = await res.json();
          setParametros(data);
        }
      } catch (err) {
        console.log('Backend no disponible en http://localhost:8000');
      }
    };
    obtenerParametros();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const lanzarError = (mensaje) => {
    setErrorMsg(mensaje);
    setShowModalError(true);
  };

  const validarFormulario = () => {
    const pesoNum = parseFloat(formData.peso);

    if (!formData.peso || isNaN(pesoNum)) {
      lanzarError('Por favor, ingresa un peso numérico válido.');
      return false;
    }

    if (pesoNum <= 0) {
      lanzarError('El peso ingresado debe ser mayor a 0.00 kg.');
      return false;
    }

    // Regla BR-02
    if (pesoNum > 20.00) {
      lanzarError('Límite de peso excedido. El peso máximo permitido por paquete es 20.00 kg.');
      return false;
    }

    return true;
  };

 const handleSubmit = async (e) => {
    e.preventDefault();
    if (!validarFormulario()) return;

    setLoading(true);
    setResultado(null);

    const pesoNum = parseFloat(formData.peso);

    // Mapeo simple de cadenas a los IDs numéricos requeridos por la BD
    const tipoEnvioCod = formData.tipoEnvio === 'EXPRESS' ? 2 : 1; 
    const tipoClienteCod = formData.tipoCliente === 'VIP' ? 3 : (formData.tipoCliente === 'FRECUENTE' ? 2 : 1);

    try {
      // Petición POST al endpoint de Laravel
      const response = await fetch('http://localhost:8000/api/envios', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          cliente_cod: formData.clienteCod || null,
          peso_envio: pesoNum,
          tipo_env_cod: tipoEnvioCod,
          tipo_cli_cod: tipoClienteCod
        }),
      });

      if (!response.ok) throw new Error('Respuesta no válida del servidor');

      const data = await response.json();

      // Adaptación si el backend responde con los nombres de la BD (snake_case o PascalCase)
      setResultado({
        tarifaBase: data.Tarifa_Base_Envio ?? data.tarifaBase ?? 5.00,
        costoPeso: data.Costo_Peso_Envio ?? data.costoPeso ?? (pesoNum <= 5 ? pesoNum * 2 : pesoNum * 4),
        subtotal: data.Subtotal_Envio ?? data.subtotal ?? 0,
        valorDescuento: data.Valor_Desc_Envio ?? data.valorDescuento ?? 0,
        valorRecargo: data.Valor_Rec_Envio ?? data.valorRecargo ?? 0,
        total: data.Total_Envio ?? data.total ?? 0
      });
      setShowModalResult(true);
    } catch (err) {

      // MOCK BACKUP: Cálculo local directo si la API de Laravel está apagada
      const tarifaBase = 5.00;
      const precioPorKg = pesoNum <= 5.00 ? 2.00 : 4.00;
      const costoPeso = pesoNum * precioPorKg;
      const subtotal = tarifaBase + costoPeso;

      let descPct = 0;
      if (formData.tipoCliente === 'FRECUENTE') descPct = 0.10;
      if (formData.tipoCliente === 'VIP') descPct = 0.20;
      const valorDescuento = subtotal * descPct;

      const recargoPct = formData.tipoEnvio === 'EXPRESS' ? 0.25 : 0.00;
      const valorRecargo = subtotal * recargoPct;

      const total = subtotal - valorDescuento + valorRecargo;

      setResultado({
        tarifaBase,
        costoPeso,
        subtotal,
        valorDescuento,
        valorRecargo,
        total
      });
      setShowModalResult(true);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container py-5">
      <div className="row justify-content-center">
        <div className="col-md-8 col-lg-6">
          
          <div className="card calculator-card">
            
            
            <div className="card-header-custom">
              <h3 className="mb-0 fw-bold">FastExpress📦</h3>
              <small className="opacity-75">Calculadora de Tarifas de Envío</small>
            </div>

            <div className="card-body p-4">

              {/* Indicador de API */}
              <div className="d-flex align-items-center justify-content-between mb-3">
                <span className="text-muted small">Estado de API:</span>
                {parametros ? (
                  <span className="status-pill status-online">● Conectado (Port 8000)</span>
                ) : (
                  <span className="status-pill status-offline">○ Modo Standalone</span>
                )}
              </div>

              {/* Formulario */}
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label className="form-label-custom">Código del Cliente (Opcional)</label>
                  <input
                    type="text"
                    className="form-control form-control-lg fs-6"
                    name="clienteCod"
                    value={formData.clienteCod}
                    onChange={handleChange}
                    placeholder="Ej. CLI-1092"
                  />
                </div>

                <div className="mb-3">
                  <label className="form-label-custom">Peso del Paquete (kg) <span className="text-danger">*</span></label>
                  <div className="input-group">
                    <input
                      type="number"
                      step="0.01"
                      className="form-control form-control-lg fs-6"
                      name="peso"
                      value={formData.peso}
                      onChange={handleChange}
                      placeholder="0.01 - 20.00"
                      required
                    />
                    <span className="input-group-text">kg</span>
                  </div>
                  <div className="helper-text">Rango válido: 0.01 kg a 20.00 kg</div>
                </div>

                <div className="row g-3 mb-4">
                  <div className="col-md-6">
                    <label className="form-label-custom">Tipo de Cliente</label>
                    <select
                      className="form-select form-select-lg fs-6"
                      name="tipoCliente"
                      value={formData.tipoCliente}
                      onChange={handleChange}
                    >
                      <option value="NUEVO">Nuevo (0% Desc.)</option>
                      <option value="FRECUENTE">Frecuente (10% Desc.)</option>
                      <option value="VIP">VIP (20% Desc.)</option>
                    </select>
                  </div>

                  <div className="col-md-6">
                    <label className="form-label-custom">Tipo de Envío</label>
                    <select
                      className="form-select form-select-lg fs-6"
                      name="tipoEnvio"
                      value={formData.tipoEnvio}
                      onChange={handleChange}
                    >
                      <option value="ESTANDAR">Estándar (+0%)</option>
                      <option value="EXPRESS">Express (+25%)</option>
                    </select>
                  </div>
                </div>

                <button
                  type="submit"
                  disabled={loading}
                  className="btn btn-success btn-lg w-100 btn-submit-custom"
                >
                  {loading ? 'Calculando...' : 'Calcular Cotización'}
                </button>
              </form>

            </div>
          </div>

        </div>
      </div>

  
      {showModalResult && resultado && (
        <div className="modal-overlay" onClick={() => setShowModalResult(false)}>
          <div className="modal-card-custom" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header-green">
              <h5 className="mb-0 fw-bold text-white">🧾 Detalle del Envío</h5>
              <button type="button" className="btn-close" onClick={() => setShowModalResult(false)}></button>
            </div>
            <div className="p-4">
              <div className="receipt-total-banner">
                <div className="receipt-total-label">TOTAL A PAGAR</div>
                <div className="receipt-total-amount">
                  ${resultado.total?.toFixed(2)} <span className="fs-6 fw-normal">USD</span>
                </div>
              </div>

              <div className="receipt-row">
                <span className="text-muted">Tarifa Base:</span>
                <span className="fw-semibold">${resultado.tarifaBase?.toFixed(2)} USD</span>
              </div>
              <div className="receipt-row">
                <span className="text-muted">Costo por Peso:</span>
                <span className="fw-semibold">${resultado.costoPeso?.toFixed(2)} USD</span>
              </div>
              <div className="receipt-row">
                <span className="text-muted">Subtotal:</span>
                <span className="fw-semibold">${resultado.subtotal?.toFixed(2)} USD</span>
              </div>

              <div className="receipt-divider"></div>

              <div className="receipt-row text-danger">
                <span>Descuento aplicado:</span>
                <span>-${resultado.valorDescuento?.toFixed(2)} USD</span>
              </div>
              <div className="receipt-row text-primary">
                <span>Recargo Express (+25%):</span>
                <span>+${resultado.valorRecargo?.toFixed(2)} USD</span>
              </div>

              <button 
                className="btn btn-outline-success w-100 mt-4 rounded-3 fw-bold py-2"
                onClick={() => setShowModalResult(false)}
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      )}

    
      {showModalError && (
        <div className="modal-overlay" onClick={() => setShowModalError(false)}>
          <div className="modal-card-custom" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header-custom bg-danger text-white">
              <h5 className="mb-0 fw-bold">⚠️ Atención</h5>
              <button type="button" className="btn-close btn-close-white" onClick={() => setShowModalError(false)}></button>
            </div>
            <div className="p-4">
              <div className="modal-error-banner">
                <div className="modal-error-icon">🚫</div>
                <div className="fw-semibold fs-6">{errorMsg}</div>
              </div>

              {/* Se agrega mt-3 para mayor separación */}
              <button 
                className="btn btn-danger w-100 rounded-3 fw-bold py-2"
                onClick={() => setShowModalError(false)}
              >
                Entendido
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}