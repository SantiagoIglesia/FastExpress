import React, { useState } from 'react';

export default function App() {
  const [formData, setFormData] = useState({
    clienteCod: '',
    peso: '',
    tipoCliente: 'NUEVO', // BR-03
    tipoEnvio: 'ESTANDAR' // BR-04
  });

  const [resultado, setResultado] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
    setError('');
  };

  // Validaciones del Frontend (UI)
  const validarFormulario = () => {
    const pesoNum = parseFloat(formData.peso);

    if (!formData.peso || isNaN(pesoNum)) {
      setError('Por favor, ingresa un peso válido.');
      return false;
    }

    if (pesoNum <= 0) {
      setError('El peso debe ser mayor a 0 kg.');
      return false;
    }

    // BR-02: Límite excedido si es mayor a 20 kg
    if (pesoNum > 20.00) {
      setError('El peso excede el límite permitido de 20.00 kg. Envío rechazado.');
      return false;
    }

    return true;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!validarFormulario()) return;

    setLoading(true);
    setResultado(null);

    try {
      // Ajusta este puerto al puerto donde tu compañero corra la API backend
      const response = await fetch('http://localhost:8080/api/cotizaciones', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          clienteCod: formData.clienteCod,
          peso: parseFloat(formData.peso),
          tipoCliente: formData.tipoCliente,
          tipoEnvio: formData.tipoEnvio
        }),
      });

      if (!response.ok) {
        throw new Error('Error al procesar la cotización en el servidor.');
      }

      const data = await response.json();
      setResultado(data);
    } catch (err) {
      setError(err.message || 'Error de conexión con el backend.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={{ maxWidth: '500px', margin: '40px auto', fontFamily: 'sans-serif', padding: '20px', border: '1px solid #ddd', borderRadius: '8px' }}>
      <h2>Cotizador de Envíos FastExpress</h2>

      <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
        <div>
          <label style={{ display: 'block', marginBottom: '5px' }}>Código del Cliente (Opcional):</label>
          <input
            type="text"
            name="clienteCod"
            value={formData.clienteCod}
            onChange={handleChange}
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <div>
          <label style={{ display: 'block', marginBottom: '5px' }}>Peso del Paquete (kg):</label>
          <input
            type="number"
            step="0.01"
            name="peso"
            value={formData.peso}
            onChange={handleChange}
            placeholder="Ej. 4.5"
            required
            style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
          />
        </div>

        <div>
          <label style={{ display: 'block', marginBottom: '5px' }}>Tipo de Cliente:</label>
          <select 
            name="tipoCliente" 
            value={formData.tipoCliente} 
            onChange={handleChange}
            style={{ width: '100%', padding: '8px' }}
          >
            <option value="NUEVO">Nuevo (0% desc.)</option>
            <option value="FRECUENTE">Frecuente (10% desc.)</option>
            <option value="VIP">VIP (20% desc.)</option>
          </select>
        </div>

    

        <div>
          <label style={{ display: 'block', marginBottom: '5px' }}>Tipo de Envío:</label>
          <select 
            name="tipoEnvio" 
            value={formData.tipoEnvio} 
            onChange={handleChange}
            style={{ width: '100%', padding: '8px' }}
          >
            <option value="ESTANDAR">Estándar (0% recargo)</option>
            <option value="EXPRESS">Express (+25% recargo)</option>
          </select>
        </div>

        <button 
          type="submit" 
          disabled={loading} 
          style={{ padding: '10px', backgroundColor: '#007bff', color: '#fff', border: 'none', borderRadius: '4px', cursor: 'pointer' }}
        >
          {loading ? 'Calculando...' : 'Calcular Cotización'}
        </button>
      </form>

      {error && (
        <div style={{ color: 'red', marginTop: '15px', padding: '10px', backgroundColor: '#ffe6e6', borderRadius: '4px' }}>
          ⚠️ {error}
        </div>
      )}

      {resultado && (
        <div style={{ marginTop: '20px', backgroundColor: '#f9f9f9', padding: '15px', borderRadius: '4px' }}>
          <h3>Resumen de Cotización</h3>
          <p><strong>Tarifa Base:</strong> ${resultado.tarifaBase?.toFixed(2)} USD</p>
          <p><strong>Costo por Peso:</strong> ${resultado.costoPeso?.toFixed(2)} USD</p>
          <p><strong>Subtotal:</strong> ${resultado.subtotal?.toFixed(2)} USD</p>
          <p><strong>Descuento:</strong> -${resultado.valorDescuento?.toFixed(2)} USD</p>
          <p><strong>Recargo Express:</strong> +${resultado.valorRecargo?.toFixed(2)} USD</p>
          <hr />
          <h4>Total a Pagar: ${resultado.total?.toFixed(2)} USD</h4>
        </div>
      )}
    </div>
  );
}