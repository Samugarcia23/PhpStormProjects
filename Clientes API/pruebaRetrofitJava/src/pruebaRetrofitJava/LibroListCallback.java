package pruebaRetrofitJava;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.util.ArrayList;
import java.util.List;

public class LibroListCallback implements Callback<List<Libro>> {

    @Override
    public void onResponse(Call<List<Libro>> call, Response<List<Libro>> response) {

        ArrayList<Libro> arrayList = new ArrayList<Libro>(response.body());
        System.out.println("Lista Cargada Correctamente: \n");
        for(Libro libro : arrayList){ //: significa foreach
            System.out.println("Codigo: " + libro.getCodigo()+ " || Titulo: " +libro.getTitulo()+" || Paginas: "+libro.getNumpag());
        }

    }

    @Override
    public void onFailure(Call<List<Libro>> call, Throwable throwable) {
        System.out.println("Error al cargar la lista, intentelo de nuevo");
    }
}
